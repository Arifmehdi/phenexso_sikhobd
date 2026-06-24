<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Enrollment;
use App\Models\ExamAttempt;
use App\Models\Product;
use App\Models\WebsiteParameter;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateController extends Controller
{
    /**
     * List the authenticated user's certificates.
     */
    public function index()
    {
        $certificates = Certificate::with('course')
            ->where('user_id', Auth::id())
            ->latest('issued_at')
            ->get();

        return view('user.certificates', compact('certificates'));
    }

    /**
     * Issue (if eligible) and download the certificate for a completed course.
     * Idempotent: re-issuing returns the existing certificate.
     */
    public function generate(Product $product)
    {
        $user = Auth::user();
        $isBn = app()->getLocale() == 'bn';

        // Must be enrolled in this course
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if (!$enrollment) {
            return redirect()->route('user.dashboard', ['activeTab' => 'courses'])
                ->with('error', $isBn ? 'আপনি এই কোর্সে এনরোল করেননি।' : 'You are not enrolled in this course.');
        }

        // Must have completed 100% of the course
        if (!$product->isCompletedByUser($user->id)) {
            return redirect()->route('user.dashboard', ['activeTab' => 'courses'])
                ->with('error', $isBn
                    ? 'সার্টিফিকেট পেতে হলে সম্পূর্ণ কোর্স শেষ করুন।'
                    : 'Please complete the full course to receive your certificate.');
        }

        // Best exam performance (optional — printed if available)
        $bestScore = $this->bestExamScore($user->id);

        $certificate = Certificate::firstOrCreate(
            ['user_id' => $user->id, 'product_id' => $product->id],
            [
                'enrollment_id' => $enrollment->id,
                'final_score'   => $bestScore,
                'issued_at'     => now(),
            ]
        );

        // Assign a readable certificate number once
        if (empty($certificate->certificate_number)) {
            $certificate->certificate_number = 'SKB-' . now()->format('Y') . '-' . str_pad($certificate->id, 5, '0', STR_PAD_LEFT);
            $certificate->save();
        }

        // Reflect completion on the enrollment
        if ($enrollment->status !== 'completed') {
            $enrollment->update(['status' => 'completed']);
        }

        $ws = WebsiteParameter::first();
        $pdf = Pdf::loadView('user.certificate', compact('certificate', 'product', 'user', 'ws'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('certificate-' . $certificate->certificate_number . '.pdf');
    }

    /**
     * Best completed-exam score as a percentage, or null if none.
     */
    private function bestExamScore($userId)
    {
        $best = ExamAttempt::where('user_id', $userId)
            ->where('status', 'completed')
            ->with('exam')
            ->get()
            ->map(function ($attempt) {
                $questions = optional($attempt->exam)->question_count ?: 0;
                return $questions > 0 ? round(($attempt->score / $questions) * 100, 2) : null;
            })
            ->filter()
            ->max();

        return $best ?: null;
    }
}
