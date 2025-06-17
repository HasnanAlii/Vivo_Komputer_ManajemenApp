<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pernyataan Jual Beli</title>
    <style>
        @media print {
            body {
                margin: 0;
            }
        }

        @page {
            size: A4;
            margin: 5mm;
            margin-left: 25mm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.6;
            margin: 0;
        }
         table {
        border-collapse: collapse;
    }
    td {
        padding: 2px 6px; /* padding kecil agar rapat */
        vertical-align: top; /* agar teks sejajar atas */
    }
    td:first-child {
        width: 120px; /* lebar tetap untuk kolom label agar rapi */
        font-weight: bold;
        white-space: nowrap; /* supaya label tidak wrap */
    }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .signature-space {
            margin-top: 60px;
        }

        .signature-line {
            display: inline-block;
            width: 200px;
            text-align: center;
            margin: 0 20px;
        }

        .border-bottom {
            border-bottom: 1px dashed #000;
            display: inline-block;
            width: 200px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            vertical-align: top;
            padding: 3px 5px;
        }

        .print-button {
            display: none;
        }

        @media screen {
            .print-button {
                display: block;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <button class="print-button" onclick="window.print()">Cetak Dokumen</button>


    <h3 class="text-center">SURAT PERNYATAAN JUAL BELI</h3>

    <p>Saya yang bertanda tangan di bawah ini:</p>
    <table>
    <tr>
        <td><strong>Nama</strong></td>
        <td>: {{ $purchasing->customer->nama }}</td>
    </tr>
    <tr>
        <td><strong>Alamat</strong></td>
        <td>: {{ $purchasing->customer->alamat }}</td>
    </tr>
    <tr>
        <td><strong>No. HP</strong></td>
        <td>: {{ $purchasing->customer->noTelp }}</td>
    </tr>
</table>

<p style="margin-top: 20px;">
    Dengan ini menyatakan bahwa saya telah melakukan penjualan barang dengan rincian sebagai berikut:
</p>
<table style="width: 100%; margin-top: 10px;">
    <tr>
        <!-- Kolom kiri: Data Barang -->
        <td style="width: 55%; vertical-align: top;">
            <table>
                <tr>
                    <td><strong>Nama Barang</strong></td>
                    <td>: {{ $purchasing->product->namaBarang }}</td>
                </tr>
                <tr>
                    <td><strong>Jumlah</strong></td>
                    <td>: {{ $purchasing->jumlah }}</td>
                </tr>
                <tr>
                    <td><strong>Merek / Tipe</strong></td>
                    <td>: {{ $purchasing->type }}</td>
                </tr>
                <tr>
                    <td><strong>Serial Number</strong></td>
                    <td>: {{ $purchasing->serialNumber }}</td>
                </tr>
                <tr>
                    <td><strong>Spesifikasi</strong></td>
                    <td>: {{ $purchasing->spek }}</td>
                </tr>
                <tr>
                    <td><strong>Harga</strong></td>
                    <td>: Rp {{ number_format($purchasing->hargaBeli, 0, ',', '.') }}</td>
                </tr>
            </table>
        </td>

        <!-- Kolom kanan: Foto Bukti -->
        <td style="width: 40%; text-align: center; vertical-align: top;">
            @if ($purchasing->buktiTransaksi)
                <a href="{{ asset($purchasing->buktiTransaksi) }}" target="_blank">
                    <img src="{{ asset($purchasing->buktiTransaksi) }}"
                         alt="Bukti Transaksi"
                         style="max-width: 100%; height: auto; max-height: 320px; border: 1px solid #ccc; padding: 6px; margin-left: 10px;">
                </a>
            @else
                <span style="color: #888;">(Tidak ada bukti)</span>
            @endif
        </td>
    </tr>
</table>




    <p>Barang tersebut adalah milik pribadi saya, bukan milik orang lain atau hasil dari tindakan melawan hukum (barang curian).</p>

    <p>Transaksi dilakukan melalui media daring (online).</p>

    <p>
        Demikian surat pernyataan ini saya buat dengan sebenar-benarnya tanpa adanya paksaan dari pihak manapun. 
        Apabila di kemudian hari terdapat tuntutan dari pihak ketiga, maka saya bertanggung jawab sepenuhnya, 
        termasuk mengembalikan dana yang telah diterima kepada pembeli. Dengan demikian, pembeli tidak dapat dianggap sebagai penadah, 
        bebas dari tanggung jawab hukum, dan tidak dapat dipidanakan.
    </p>

    <p>Terima kasih.</p>
    <div class="text-left">Cianjur, {{ \Carbon\Carbon::parse($purchasing->tanggal)->format('d/m/Y') }}</div>

 <table style="width: 100%;  text-align: center;">
    <tr>
        <td style="width: 50%; padding-bottom: 60px;">Pembeli</td>
        <td style="width: 50%; padding-bottom: 60px;">Penjual</td>
    </tr>
    <tr style="height: 120x;">
        <td>
            Vivo Komputer
        </td>
        <td>
        
            <div >{{ $purchasing->customer->nama }}</div>
        </td>
    </tr>
</table>

<!-- Tanda Tangan Saksi -->
<table style="width: 100%; text-align: center; margin-top: 20px;">
    <tr>
        <td>Saksi I</td>
        <td>Saksi II</td>
        <td>Saksi III</td>
    </tr>
    <tr style="height: 80px;">
        <td>
            <div style="border-bottom: 1px dashed #000; width: 180px; margin: 0 auto;margin-top: 40px;"></div>
        </td>
        <td>
            <div style="border-bottom: 1px dashed #000; width: 180px; margin: 0 auto; margin-top: 40px;"></div>
        </td>
        <td>
            <div style="border-bottom: 1px dashed #000; width: 180px; margin: 0 auto; margin-top: 40px;"></div>
        </td>
    </tr>
</table>


    <script>window.print();</script>
</body>
</html>
