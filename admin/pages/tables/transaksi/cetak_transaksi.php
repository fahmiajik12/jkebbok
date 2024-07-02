<?php
require_once('book_store/vendor/tecnickcom/tcpdf/tcpdf.php');
include('htdocs/book_store/helper/connection.php');

use TCPDF\TCPDF;

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Data Transaksi');

// Add a page
$pdf->AddPage();

// Set some content to display
$content = '<h1>Data Transaksi</h1>';
$content .= '<table border="1">
                <tr>
                    <th>No</th>
                    <th>ID Transaksi</th>
                    <th>Nama Customer</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Transaksi</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                </tr>';

// Sample data query (you can modify this according to your actual database structure)
$query = "SELECT t.id_transaksi, c.nama_customer, b.judul_buku, t.tgl_transaksi, t.jumlah, t.total 
          FROM transaksi t, customer c, buku b 
          WHERE t.id_customer = c.id_customer AND b.id_buku = t.id_buku";

// Execute query (you need to establish database connection first)
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
    $index = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $content .= '<tr>
                        <td>' . $index++ . '</td>
                        <td>' . $row["id_transaksi"] . '</td>
                        <td>' . $row["nama_customer"] . '</td>
                        <td>' . $row["judul_buku"] . '</td>
                        <td>' . $row["tgl_transaksi"] . '</td>
                        <td>' . $row["jumlah"] . '</td>
                        <td>Rp.' . $row["total"] . ',-</td>
                    </tr>';
    }
}

$content .= '</table>';

// Print content using WriteHTML method providing the header/footer
$pdf->writeHTML($content, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('data_transaksi.pdf', 'I');

// Close MySQL connection
mysqli_close($con);
?>