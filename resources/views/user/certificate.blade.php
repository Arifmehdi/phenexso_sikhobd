<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate - {{ $certificate->certificate_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        @page { margin: 0; }
        body { font-family: 'DejaVu Sans', sans-serif; color: #1e293b; }

        .sheet {
            width: 100%;
            height: 540pt;
            padding: 18pt;
        }
        .frame {
            border: 3px solid #1e3a8a;
            height: 100%;
            padding: 6pt;
        }
        .inner {
            border: 1px solid #c7a008;
            height: 100%;
            padding: 28pt 40pt;
            text-align: center;
            position: relative;
        }

        .brand {
            font-size: 13pt;
            letter-spacing: 3pt;
            text-transform: uppercase;
            color: #1e3a8a;
            font-weight: bold;
        }
        .title {
            font-size: 34pt;
            font-weight: bold;
            color: #1e3a8a;
            margin-top: 10pt;
        }
        .subtitle {
            font-size: 11pt;
            color: #c7a008;
            letter-spacing: 4pt;
            text-transform: uppercase;
            margin-top: 2pt;
        }
        .lead {
            font-size: 11pt;
            color: #64748b;
            margin-top: 26pt;
        }
        .student {
            font-size: 28pt;
            font-weight: bold;
            color: #0f172a;
            margin-top: 8pt;
            border-bottom: 1px solid #cbd5e1;
            display: inline-block;
            padding: 0 30pt 6pt;
        }
        .desc {
            font-size: 11pt;
            color: #64748b;
            margin-top: 16pt;
        }
        .course {
            font-size: 18pt;
            font-weight: bold;
            color: #1e3a8a;
            margin-top: 6pt;
        }
        .score {
            font-size: 11pt;
            color: #166534;
            margin-top: 10pt;
            font-weight: bold;
        }

        .footer {
            position: absolute;
            bottom: 24pt;
            left: 40pt;
            right: 40pt;
        }
        .footer td {
            font-size: 9.5pt;
            color: #475569;
            vertical-align: bottom;
        }
        .sigline {
            border-top: 1px solid #475569;
            width: 150pt;
            margin: 0 auto;
            padding-top: 4pt;
            font-weight: bold;
            color: #0f172a;
        }
        .muted { color: #94a3b8; font-size: 8.5pt; }
        .seal {
            font-size: 9pt;
            color: #c7a008;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1pt;
        }
    </style>
</head>
<body>
    <div class="sheet">
        <div class="frame">
            <div class="inner">
                <div class="brand">{{ $ws->website_title ?? config('app.name') }}</div>

                <div class="title">Certificate of Completion</div>
                <div class="subtitle">Course Achievement Award</div>

                <div class="lead">This is to certify that</div>
                <div class="student">{{ $user->name }}</div>

                <div class="desc">has successfully completed the course</div>
                <div class="course">{{ $product->name_en ?? $product->name_bn }}</div>

                @if(!is_null($certificate->final_score))
                    <div class="score">Assessment Score: {{ rtrim(rtrim(number_format($certificate->final_score, 2), '0'), '.') }}%</div>
                @endif

                <div class="footer">
                    <table width="100%">
                        <tr>
                            <td width="33%" style="text-align:left;">
                                <strong>Certificate No.</strong><br>
                                {{ $certificate->certificate_number }}<br>
                                <span class="muted">Issued: {{ optional($certificate->issued_at)->format('d M, Y') }}</span>
                            </td>
                            <td width="34%" style="text-align:center;">
                                <div class="seal">&#9733; Verified &#9733;</div>
                            </td>
                            <td width="33%" style="text-align:right;">
                                <div class="sigline">Authorized Signature</div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
