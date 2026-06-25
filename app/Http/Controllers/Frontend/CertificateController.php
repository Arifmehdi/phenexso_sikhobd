<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Enrollment;
use App\Models\Exam;
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
        $certificates = Certificate::with('course', 'exam')
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
        $itemName = $product->name_en ?? $product->name_bn;
        $completedLabel = 'for successfully completing the course';
        $pdf = Pdf::loadView('user.certificate', compact('certificate', 'user', 'ws', 'itemName', 'completedLabel'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('certificate-' . $certificate->certificate_number . '.pdf');
    }

    /**
     * Issue (if eligible) and download the certificate for a completed exam.
     */
    public function generateExam(Exam $exam)
    {
        $user = Auth::user();
        $isBn = app()->getLocale() == 'bn';

        // Must have a completed attempt for this exam
        $attempt = ExamAttempt::where('exam_id', $exam->id)
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->latest('end_time')
            ->first();

        if (!$attempt) {
            return redirect()->route('exams.index')
                ->with('error', $isBn
                    ? 'সার্টিফিকেট পেতে হলে আগে পরীক্ষাটি সম্পন্ন করুন।'
                    : 'Please complete the exam to receive your certificate.');
        }

        // Results must be published by admin
        if ($exam->status !== 'finished') {
            return redirect()->route('exams.result', $exam->id)
                ->with('error', $isBn
                    ? 'ফলাফল প্রকাশের পর সার্টিফিকেট পাওয়া যাবে।'
                    : 'The certificate will be available once results are published.');
        }

        $score = ($exam->question_count > 0)
            ? round(($attempt->score / $exam->question_count) * 100, 2)
            : null;

        $certificate = Certificate::firstOrCreate(
            ['user_id' => $user->id, 'exam_id' => $exam->id, 'type' => 'exam'],
            [
                'final_score' => $score,
                'issued_at'   => now(),
            ]
        );

        if (empty($certificate->certificate_number)) {
            $certificate->certificate_number = 'SKB-EX-' . now()->format('Y') . '-' . str_pad($certificate->id, 5, '0', STR_PAD_LEFT);
            $certificate->save();
        }

        $ws = WebsiteParameter::first();
        $itemName = $exam->title;
        $completedLabel = 'for successfully completing the examination';
        $pdf = Pdf::loadView('user.certificate', compact('certificate', 'user', 'ws', 'itemName', 'completedLabel'))
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
