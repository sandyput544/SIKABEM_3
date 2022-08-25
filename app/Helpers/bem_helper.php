<?php

// Function SetFlashData
function flashAlert($alert_type = null, $alert_msg = null, $icon = 'bi-check-circle-fill')
{
    session()->setFlashdata('pesan', '
        <div class="col-12">
            <div class="alert alert-' . $alert_type . ' d-flex align-items-center alert-dismissible" role="alert">
                <i class="' . $icon . '" flex-shrink-0 me-2"></i>
                ' . $alert_msg . '
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
