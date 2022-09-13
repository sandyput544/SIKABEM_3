<?php

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Writer\Word2007;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\Settings;
// use CodeIgniter\I18n\Time;

// Function SetFlashData
function flashAlert($alert_type = null, $alert_msg = null, $icon = 'bi-check-circle-fill')
{
    session()->setFlashdata('pesan', '
        <div class="col-12">
            <div class="alert alert-' . $alert_type . ' d-flex align-items-center alert-dismissible" role="alert">
                <span class="' . $icon . '" flex-shrink-0">  ' . $alert_msg . '</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>');
}

// Function showMyError
function showError($field = null)
{
    $validation = \Config\Services::validation();
    if ($validation->hasError($field)) {
        echo '<small class="text-danger">' . $validation->getError($field) . '</small>';
    }
}

function checked($data = null, $type = null)
{
    if ($data == $type) {
        echo 'checked';
    }
}

// Function post_access
function getPosAccess($kd_jabatan, $kd_menu)
{
    $db =  \Config\Database::connect();
    $get_posmenu = $db->query('
    SELECT * FROM position_menu WHERE kd_jabatan=' . $kd_jabatan . ' AND kd_menu=' . $kd_menu . '
    ');

    if ($get_posmenu->getNumRows() > 0) {
        return "checked";
    }
}

// Function createDocx
function createWord($judul, $nomor)
{
    $phpWord = new PhpWord();
    $converter = new Converter();
    $settings = new Settings();
    $writer = new Word2007($phpWord);

    // Set Paper
    $settings->setDefaultPaper('A4');

    /* 
        Set Default Style
        1. Set font style default
        2. Set paragraf style default
    */
    $defaultFontStyle = [
        'name' => 'Times New Roman',
        'size' => '12',
        'color' => '000000',
        'bold' => false,
        'underline' => false,
        'allCaps' => false,
    ];
    $defaultParagraphStyle = [
        'alignment' => PhpOffice\PhpWord\SimpleType\Jc::BOTH,
        'spaceAfter' => $converter->pointToTwip(0),
        'spaceBefore' => $converter->pointToTwip(6),
        'indentation' => ['left' => 1],
        'lineHeight' => '1.0',
        'widowControl' => true,
    ];

    $phpWord->setDefaultFontName('Times New Roman');
    $phpWord->setDefaultFontSize('12');
    $phpWord->setDefaultParagraphStyle($defaultParagraphStyle);

    /* 
        Set Judul Surat
        1. Set font style judul
        2. Set paragraf style judul
    */
    // $namaFontStyleJudul = "judul_surat";
    // $phpWord->addFontStyle($namaFontStyleJudul, $fontStyleJudul);
    $fontStyleJudul = [
        'name' => 'Times New Roman',
        'size' => '14',
        'color' => '000000',
        'bold' => true,
        'underline' => true,
        'allCaps' => true,
    ];
    $paragraphStyleJudul = [
        'alignment' => PhpOffice\PhpWord\SimpleType\Jc::CENTER,
        'spaceAfter' => $converter->pointToTwip(12),
        'spaceBefore' => $converter->pointToTwip(0),
        'indentation' => ['left' => 0],
        'widowControl' => true,
    ];

    /*
        Set nomor surat
        1. Set font style nomor
        2. Set paragraph style nomor
    */
    $fontStyleNomor = [
        'name' => 'Times New Roman',
        'size' => '12',
        'color' => '000000',
        'bold' => true,
        'underline' => false,
        'allCaps' => true,
    ];
    $paragraphStyleNomor = [
        'alignment' => PhpOffice\PhpWord\SimpleType\Jc::CENTER,
        'spaceAfter' => $converter->pointToTwip(0),
        'spaceBefore' => $converter->pointToTwip(12),
        'indentation' => ['left' => 0],
        'widowControl' => true,
    ];

    // Set Margin
    $sectionStyle = [
        'marginTop' => $converter->cmToTwip(3),
        'marginRight' => $converter->cmToTwip(2),
        'marginBottom' => $converter->cmToTwip(2),
        'marginLeft' => $converter->cmToTwip(2),
        'orientation' => 'portrait'
    ];

    // Buat Section
    $section = $phpWord->addSection($sectionStyle);
    $section->addTitleStyle(1, $fontStyleJudul, $paragraphStyleJudul);
    $section->addTitle($judul, 1);
    $section->addText($nomor, $fontStyleNomor, $paragraphStyleNomor);
    $section->addTextBreak(2);
    $section->addText("Ketikkan dan isi surat anda disini.", $defaultFontStyle, $defaultParagraphStyle);

    $nama_file = $nomor . "_" . $judul;

    header('Content-Type: application/msword');
    header('Content-Disposition: attachment;filename="' . $nama_file . '.docx"');
    header('Cache-Control: max-age=0');
    return $writer->save("php://output");
}
