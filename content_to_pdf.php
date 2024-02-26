<?php

// Your HTML data
// $htmlData = $_POST["content"];

// // Save HTML data to a temporary file
// $filePath = tempnam(sys_get_temp_dir(), 'html_to_pdf');
// file_put_contents($filePath, $htmlData);

// // Output PDF file path
// $pdfFilePath = sys_get_temp_dir() . '/output.pdf';

// // Command to convert HTML to PDF using wkhtmltopdf
// $command = "wkhtmltopdf $filePath $pdfFilePath";

// // Execute the command
// shell_exec($command);

// // Output the PDF file to the browser
// header('Content-type: application/pdf');
// header('Content-Disposition: inline; filename="output.pdf"');
// readfile($pdfFilePath);

// // Clean up temporary files
// unlink($filePath);
// unlink($pdfFilePath);

// $content = $_POST["content"];
$content = '<table id="full-details-table" cellspacing="0">
<th>SNo.</th>
<th>Date</th>
<th>Category</th>
<th>Description</th>
<th>Cost</th>
</tr>

<tr>
<td>1</td>
<td>25 February</td>
<td>B (30%)</td>
<td>Swimming + Lunch</td>
<td>365.00</td>
</tr>

<tr>
<td>2</td>
<td>23 February</td>
<td>B (30%)</td>
<td>Polaroids X 13</td>
<td>240.00</td>
</tr>

<tr>
<td>2</td>
<td>23 February</td>
<td>B (30%)</td>
<td>Polaroids X 13</td>
<td>240.00</td>
</tr>

<tr>
<td>2</td>
<td>23 February</td>
<td>B (30%)</td>
<td>Polaroids X 13</td>
<td>240.00</td>
</tr>

<tr>
<td>2</td>
<td>23 February</td>
<td>B (30%)</td>
<td>Polaroids X 13</td>
<td>240.00</td>
</tr>

<tr>
<td>2</td>
<td>23 February</td>
<td>B (30%)</td>
<td>Polaroids X 13</td>
<td>240.00</td>
</tr>

<tr>
<td>2</td>
<td>23 February</td>
<td>B (30%)</td>
<td>Polaroids X 13</td>
<td>240.00</td>
</tr>

<tr>
<td>2</td>
<td>23 February</td>
<td>B (30%)</td>
<td>Polaroids X 13</td>
<td>240.00</td>
</tr>

<tr>
<td>1</td>
<td>25 February</td>
<td>B (30%)</td>
<td>Swimming + Lunch</td>
<td>365.00</td>
</tr>

<tr>
<td>1</td>
<td>25 February</td>
<td>B (30%)</td>
<td>Swimming + Lunch</td>
<td>365.00</td>
</tr>

<tr>
<td>1</td>
<td>25 February</td>
<td>B (30%)</td>
<td>Swimming + Lunch</td>
<td>365.00</td>
</tr>

<tr>
<td>2</td>
<td>23 February</td>
<td>B (30%)</td>
<td>Polaroids X 13</td>
<td>240.00</td>
</tr>

<tr>
<td>2</td>
<td>23 February</td>
<td>B (30%)</td>
<td>Polaroids X 13</td>
<td>240.00</td>
</tr>

<tr>
<td>2</td>
<td>23 February</td>
<td>B (30%)</td>
<td>Polaroids X 13</td>
<td>240.00</td>
</tr>

<tr>
<td>2</td>
<td>23 February</td>
<td>B (30%)</td>
<td>Polaroids X 13</td>
<td>240.00</td>
</tr>

<tr>
<td>2</td>
<td>23 February</td>
<td>B (30%)</td>
<td>Polaroids X 13</td>
<td>240.00</td>
</tr>
</table>';

require_once "./vendor/autoload.php";

use Dompdf\Dompdf;

$page_name = "<script>document.write(sessionStorage.getItem('pdf-page-data'));</script>"; 

// $page_name = $_POST["content"];

try {

$dompdf = new Dompdf();

if ($page_name == "expense") {
    $contentt = "<h1>Hello</h1><p>To You</p>";
} else if ($page_name == "" || $page_name == null) {
    $contentt = "<h1>Bye</h1><p>Null</p>";
} else {
    $contentt = "<h1>Bye</h1><p>World</p>";
}

// $dompdf->set_option('enable_remote', TRUE);
// $dompdf->loadHtmlFile('http://localhost:8080/major-project/to_pdf.php');

// echo $page_name;

$dompdf->loadHtml($contentt);

$dompdf->render();

$dompdf->stream("sample-document.pdf");
echo "<script>alert('Success');</script>";
// header("")
} catch (Exception $some_exception) {
    // echo "<script>alert($some_exception);</script>";
    echo $some_exception;
}

?>

?>