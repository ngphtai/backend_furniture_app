<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use Barryvdh\DomPDF\Facade\Pdf ;

class PdfController extends Controller
{

    public function index(){
        return view('page.pdf');
    }

    // lỗi font chữ + lỗi đường dẫn + lỗi permission => chiuj :)))

    // public function generatePDF(){
    //     $options = new Options();

    //     $options->set('chroot', 'C:\xampp\htdocs');

    //     $dompdf = new Dompdf($options);
    //     $dompdf->set_option('chroot', 'C:\xampp\htdocs');

    //     $dompdf= Pdf::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);

    //     return $dompdf = Pdf::loadFile(public_path().'/page/pdf.blade.php')->save('D:\\my_stored_file.pdf')->stream('download.pdf');
    // }
}
