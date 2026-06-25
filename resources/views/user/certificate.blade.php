<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate - {{ $certificate->certificate_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        @page { margin: 0; }
        html, body { margin: 0; padding: 0; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #1f2937;
            background: #ffffff;
        }

        /* Page = 297mm x 210mm landscape. Keep total well under 210mm to force one page. */
        .frame {
            position: relative;
            margin: 6mm;
            height: 188mm;
            border: 6px solid #14306b;
            background: #ffffff;
        }
        .inner-border {
            position: absolute;
            top: 5mm; left: 5mm; right: 5mm;
            height: 178mm;
            border: 1.5px solid #c79a2e;
        }

        /* Decorative corner accents */
        .corner {
            position: absolute;
            width: 16mm; height: 16mm;
            border: 3px solid #c79a2e;
        }
        .corner.tl { top: 8mm; left: 8mm; border-right: 0; border-bottom: 0; }
        .corner.tr { top: 8mm; right: 8mm; border-left: 0; border-bottom: 0; }
        .corner.bl { top: 164mm; left: 8mm; border-right: 0; border-top: 0; }
        .corner.br { top: 164mm; right: 8mm; border-left: 0; border-top: 0; }

        .content {
            position: absolute;
            top: 16mm; left: 18mm; right: 18mm;
            text-align: center;
        }

        .brand {
            font-size: 11pt;
            letter-spacing: 3pt;
            text-transform: uppercase;
            color: #14306b;
            font-weight: bold;
        }
        .brand-line {
            width: 36mm;
            border-bottom: 2px solid #c79a2e;
            margin: 3pt auto 0;
        }

        .title {
            font-size: 30pt;
            font-weight: bold;
            color: #14306b;
            margin-top: 9pt;
            letter-spacing: 1pt;
        }
        .subtitle {
            font-size: 10pt;
            color: #c79a2e;
            letter-spacing: 5pt;
            text-transform: uppercase;
            margin-top: 2pt;
        }

        .lead {
            font-size: 10pt;
            color: #6b7280;
            margin-top: 15pt;
            font-style: italic;
        }
        .student {
            font-size: 23pt;
            font-weight: bold;
            color: #0f172a;
            margin-top: 6pt;
            padding-bottom: 5pt;
        }
        .student-line {
            width: 110mm;
            border-bottom: 1.5px solid #cbd5e1;
            margin: 0 auto;
        }
        .desc {
            font-size: 10pt;
            color: #6b7280;
            margin-top: 11pt;
        }
        .course {
            font-size: 15pt;
            font-weight: bold;
            color: #14306b;
            margin-top: 5pt;
        }
        .score {
            display: inline-block;
            font-size: 9.5pt;
            color: #166534;
            background: #ecfdf5;
            border: 1px solid #86efac;
            border-radius: 14pt;
            padding: 3pt 12pt;
            margin-top: 10pt;
            font-weight: bold;
        }

        /* Seal / medal */
        .seal {
            position: absolute;
            top: 118mm;
            left: 50%;
            margin-left: -13mm;
            width: 26mm; height: 26mm;
            border-radius: 50%;
            background: #14306b;
            border: 2px solid #c79a2e;
            text-align: center;
            color: #c79a2e;
        }
        .seal .star { font-size: 15pt; margin-top: 4mm; }
        .seal .seal-text { font-size: 6pt; letter-spacing: 1pt; text-transform: uppercase; margin-top: 1mm; }

        /* Footer */
        .footer {
            position: absolute;
            top: 150mm; left: 18mm; right: 18mm;
        }
        .footer td { font-size: 9.5pt; color: #475569; vertical-align: bottom; }
        .meta-label { font-size: 7.5pt; text-transform: uppercase; letter-spacing: 1pt; color: #94a3b8; }
        .meta-value { font-weight: bold; color: #0f172a; }
        .sigline {
            border-top: 1.5px solid #475569;
            width: 55mm;
            margin: 0 0 0 auto;
            padding-top: 4pt;
            font-weight: bold;
            color: #0f172a;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="frame">
        <div class="inner-border"></div>
        <div class="corner tl"></div>
        <div class="corner tr"></div>
        <div class="corner bl"></div>
        <div class="corner br"></div>

        <div class="content">
            <div class="brand">{{ $ws->website_title ?? config('app.name') }}</div>
            <div class="brand-line"></div>

            <div class="title">Certificate</div>
            <div class="subtitle">of Completion</div>

            <div class="lead">This is proudly presented to</div>
            <div class="student">{{ $user->name }}</div>
            <div class="student-line"></div>

            <div class="desc">{{ $completedLabel ?? 'for successfully completing the course' }}</div>
            <div class="course">{{ $itemName }}</div>

            @if(!is_null($certificate->final_score))
                <div class="score">Assessment Score: {{ rtrim(rtrim(number_format($certificate->final_score, 2), '0'), '.') }}%</div>
            @endif
        </div>

        <div class="seal">
            <div class="star">&#9733;</div>
            <div class="seal-text">Verified</div>
        </div>

        <div class="footer">
            <table width="100%">
                <tr>
                    <td width="40%" style="text-align:left;">
                        <div class="meta-label">Certificate No.</div>
                        <div class="meta-value">{{ $certificate->certificate_number }}</div>
                        <div class="meta-label" style="margin-top:3pt;">Issued On</div>
                        <div class="meta-value">{{ optional($certificate->issued_at)->format('d M, Y') }}</div>
                    </td>
                    <td width="20%"></td>
                    <td width="40%" style="text-align:right;">
                        <div class="sigline">Authorized Signature</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
