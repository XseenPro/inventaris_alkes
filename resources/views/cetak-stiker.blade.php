<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cetak Stiker</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="shortcut icon" href="{{ asset('images/RSU.png') }}" type="image/x-icon">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .sticker {
            border: 2px solid #000;
            padding: 3mm;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            margin: 20px auto;
            background: #fff;
            max-width: 380px;
            aspect-ratio: 10 / 3;
        }

        .sticker-header {
            text-align: center;
            font-weight: bold;
            font-size: 10pt;
            border-bottom: 2px solid #000;
            padding-bottom: 2px;
            margin-bottom: 3px;
        }

        .sticker-body {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 4mm;
        }

        .left-section {
            display: flex;
            align-items: center;
            gap: 3mm;
            flex: 1;
            min-width: 0;
        }

        .stiker-logo {
            flex-shrink: 0;
        }

        .stiker-logo img {
            width: 12mm;
            height: auto;
            display: block;
        }

        .info-section {
            font-size: 8pt;
            line-height: 1.3;
            flex: 1;
            min-width: 0;
        }

        .info-section p {
            margin: 0.5mm 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .info-section strong {
            font-weight: bold;
        }

        .barcode-section {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border-left: 1px solid #ccc;
            padding-left: 3mm;
        }

        .barcode-section svg,
        .barcode-section img {
            width: 22mm;
            height: 22mm;
            display: block;
        }

        .print-button-wrapper {
            text-align: center;
            padding: 15px;
            border-bottom: 1px solid #ddd;
            background: #fff;
            margin-bottom: 15px;
        }

        .print-button {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            background: #007bff;
            color: white;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        .print-button:hover {
            background: #0056b3;
        }

        @media (max-width: 480px) {
            .sticker {
                width: 95%;
                max-width: none;
            }

            .stiker-logo img {
                width: 10mm;
            }

            .info-section {
                font-size: 7pt;
            }

            .barcode-section svg,
            .barcode-section img {
                width: 18mm;
                height: 18mm;
            }
        }

        @media print {
            html, body {
                margin: 0;
                padding: 0;
                width: 100mm;
                height: 30mm;
            }

            .print-button-wrapper {
                display: none !important;
            }

            @page {
                size: 100mm 30mm;
                margin: 0;
            }

            body {
                background: #fff;
            }

            .sticker {
                width: 100mm;
                height: 30mm;
                max-height: 30mm;
                border: 2px solid #000;
                padding: 1.5mm;
                margin: 0;
                box-sizing: border-box;
                display: block;
                page-break-after: avoid;
                page-break-inside: avoid;
                overflow: hidden;
            }

            .sticker-header {
                font-size: 7.5pt;
                font-weight: bold;
                text-align: center;
                padding-bottom: 0.5mm;
                margin-bottom: 1mm;
                border-bottom: 2px solid #000;
            }

            .sticker-body {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 2mm;
                height: calc(30mm - 10mm);
            }

            .left-section {
                display: flex;
                align-items: center;
                gap: 2mm;
                flex: 1;
                min-width: 0;
            }

            .stiker-logo {
                flex-shrink: 0;
            }

            .stiker-logo img {
                width: 9mm;
                height: auto;
                display: block;
            }

            .info-section {
                font-size: 6pt;
                line-height: 1.2;
                flex: 1;
                min-width: 0;
            }

            .info-section p {
                margin: 0.2mm 0;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .barcode-section {
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                border-left: 1px solid #999;
                padding-left: 2mm;
            }

            .barcode-section svg,
            .barcode-section img {
                width: 18mm !important;
                height: 18mm !important;
            }
        }
    </style>
</head>
<body>
    <div class="print-button-wrapper">
        <button onclick="window.print()" class="print-button">
            <i class="fa fa-print"></i> Cetak Stiker Ini
        </button>
        <button onclick="window.location.href='{{ route('cetak.semua.stiker') }}'" class="print-button"
            style="background: #28a745;">
            <i class="fa fa-layer-group"></i> Cetak Semua Stiker
        </button>
    </div>

    <div class="sticker">
        <div class="sticker-header">LABEL INVENTARIS BARANG</div>
        <div class="sticker-body">
            <div class="left-section">
                <div class="stiker-logo">
                    <img src="{{ asset('img/RSU.png') }}" alt="logo">
                </div>

                <div class="info-section">
                    <p><strong>Nama:</strong> {{ $record->nama_perangkat }}</p>
                    <p><strong>Kode:</strong> {{ $record->nomor_inventaris }}</p>
                    <p><strong>Lokasi:</strong> {{ $record->lokasi->nama_lokasi ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="barcode-section">
                @php
                    $url = route('public.perangkat.show', ['perangkat' => $record->id]);
                    echo \SimpleSoftwareIO\QrCode\Facades\QrCode::size(70)->generate($url);
                @endphp
            </div>
        </div>
    </div>
</body>
</html>
