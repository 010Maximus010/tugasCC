// display a modal mahasiswa
$(document).on("click", "#buttonModalMahasiswa", function (event) {
    event.preventDefault();
    let href = $(this).attr("data-attr");
    $.ajax({
        url: href,
        // return the result
        success: function (result) {
            $("#mahasiswa_view").modal("show");
            $("#showModalMahasiswa").html(result).show();
        },
        error: function (jqXHR, testStatus, error) {
            console.log(error);
            alert("Page " + href + " cannot open. Error:" + error);
        },
    });
});

// display a modal dosen
$(document).on("click", "#buttonModalDosen", function (event) {
    event.preventDefault();
    let href = $(this).attr("data-attr");
    $.ajax({
        url: href,
        // return the result
        success: function (result) {
            $("#dosen_view").modal("show");
            $("#showModalDosen").html(result).show();
        },
        error: function (jqXHR, testStatus, error) {
            console.log(error);
            alert("Page " + href + " cannot open. Error:" + error);
        },
    });
});

// display a modal confirm delete mahasiswa
$(document).on("click", "#buttonConfirmDelete_Mhs", function (event) {
    event.preventDefault();
    let href = $(this).attr("data-attr");
    $.ajax({
        url: href,
        // return the result
        success: function (result) {
            $("#confirm_delete_mhs").modal("show");
            $("#showModalConfirmDelete_mhs").html(result).show();
        },
        error: function (jqXHR, testStatus, error) {
            console.log(error);
            alert("Page " + href + " cannot open. Error:" + error);
        },
    });
});

// display a modal confirm delete dosen
$(document).on("click", "#buttonConfirmDelete_dsn", function (event) {
    event.preventDefault();
    let href = $(this).attr("data-attr");
    $.ajax({
        url: href,
        // return the result
        success: function (result) {
            $("#confirm_delete_dsn").modal("show");
            $("#showModalConfirmDelete_dsn").html(result).show();
        },
        error: function (jqXHR, testStatus, error) {
            console.log(error);
            alert("Page " + href + " cannot open. Error:" + error);
        },
    });
});

// display a modal IRS
$(document).on("click", "#buttonModalIRS", function() {
    event.preventDefault();
    let href = $(this).attr("data-attr");
    $.ajax({
        url: href,
        // return the result
        success: function(result) {
            $("#editIRS").modal("show");
            $("#showModalIRS").html(result).show();
        },
        error: function(jqXHR, testStatus, error) {
            console.log(error);
            alert("Page " + href + " cannot open. Error:" + error);
        },
    });
});

// display a modal confirm delete irs
$(document).on("click", "#buttonConfirmDelete_irs", function (event) {
    event.preventDefault();
    let href = $(this).attr("data-attr");
    $.ajax({
        url: href,
        // return the result
        success: function (result) {
            $("#confirm_delete_irs").modal("show");
            $("#showModalConfirmDelete_irs").html(result).show();
        },
        error: function (jqXHR, testStatus, error) {
            console.log(error);
            alert("Page " + href + " cannot open. Error:" + error);
        },
    });
});

// display a modal KHS
$(document).on("click", "#buttonModalKHS", function() {
    event.preventDefault();
    let href = $(this).attr("data-attr");
    $.ajax({
        url: href,
        // return the result
        success: function(result) {
            $("#editKHS").modal("show");
            $("#showModalKHS").html(result).show();
        },
        error: function(jqXHR, testStatus, error) {
            console.log(error);
            alert("Page " + href + " cannot open. Error:" + error);
        },
    });
});

// display a modal confirm delete khs
$(document).on("click", "#buttonConfirmDelete_khs", function (event) {
    event.preventDefault();
    let href = $(this).attr("data-attr");
    $.ajax({
        url: href,
        // return the result
        success: function (result) {
            $("#confirm_delete_khs").modal("show");
            $("#showModalConfirmDelete_khs").html(result).show();
        },
        error: function (jqXHR, testStatus, error) {
            console.log(error);
            alert("Page " + href + " cannot open. Error:" + error);
        },
    });
});

// display a modal confirm delete pkl
$(document).on("click", "#buttonConfirmDelete_pkl", function (event) {
    event.preventDefault();
    let href = $(this).attr("data-attr");
    $.ajax({
        url: href,
        // return the result
        success: function (result) {
            $("#confirm_delete_pkl").modal("show");
            $("#showModalConfirmDelete_pkl").html(result).show();
        },
        error: function (jqXHR, testStatus, error) {
            console.log(error);
            alert("Page " + href + " cannot open. Error:" + error);
        },
    });
});

// display a modal confirm delete skripsi
$(document).on("click", "#buttonConfirmDelete_skripsi", function (event) {
    event.preventDefault();
    let href = $(this).attr("data-attr");
    $.ajax({
        url: href,
        // return the result
        success: function (result) {
            $("#confirm_delete_skripsi").modal("show");
            $("#showModalConfirmDelete_skripsi").html(result).show();
        },
        error: function (jqXHR, testStatus, error) {
            console.log(error);
            alert("Page " + href + " cannot open. Error:" + error);
        },
    });
});

let modal_content = document.getElementsByClassName("modal-content");

// click class btn-close data-bs-toggle="tab" href="#tab-1" click
$("#btnClose").click(function () {
    // function tab1 click
    $("#tab1-progress-view").click();

    // href to tab 1
    $("#tab-1-progress-view").addClass("show active");
    $("#tab-2-progress-view").removeClass("active");
    $("#tab-3-progress-view").removeClass("active");
    $("#tab-4-progress-view").removeClass("active");

    // nav-link set active
    $("#tab1-progress-view").addClass("active");
    $("#tab2-progress-view").removeClass("active");
    $("#tab3-progress-view").removeClass("active");
    $("#tab4-progress-view").removeClass("active");
});

// Event handler untuk perubahan tab pada first modal
$('#tab1-progress-view').on('shown.bs.tab', function (e) {
    modal_content[1].classList.add("bg-info");
    modal_content[1].classList.remove("bg-danger");
    modal_content[1].classList.remove("bg-warning");
    modal_content[1].classList.remove("bg-success");
});

$('#tab2-progress-view').on('shown.bs.tab', function (e) {
    modal_content[0].classList.remove("bg-info");
    modal_content[0].classList.add("bg-danger");
    modal_content[0].classList.remove("bg-warning");
    modal_content[0].classList.remove("bg-success");
});

// Event handler untuk perubahan tab pada second modal
$('#tab1-progress-view1').on('shown.bs.tab', function (e) {
    modal_content[1].classList.add("bg-info"); // Ganti indeks [1] dengan indeks yang sesuai
    modal_content[1].classList.remove("bg-danger");
    modal_content[1].classList.remove("bg-warning");
    modal_content[1].classList.remove("bg-success");
});

$('#tab2-progress-view1').on('shown.bs.tab', function (e) {
    modal_content[1].classList.remove("bg-info");
    modal_content[1].classList.add("bg-danger");
    modal_content[1].classList.remove("bg-warning");
    modal_content[1].classList.remove("bg-success");
});

$('#tab3-progress-view1').on('shown.bs.tab', function (e) {
    modal_content[1].classList.remove("bg-info");
    modal_content[1].classList.remove("bg-danger");
    modal_content[1].classList.add("bg-warning");
    modal_content[1].classList.remove("bg-success");
});
$('#tab4-progress-view1').on('shown.bs.tab', function (e) {
    modal_content[1].classList.remove("bg-info");
    modal_content[1].classList.remove("bg-danger");
    modal_content[1].classList.remove("bg-warning");
    modal_content[1].classList.add("bg-success");
});

// Event handler untuk perubahan tab pada third modal
$('#tab1-progress-view2').on('shown.bs.tab', function (e) {
    modal_content[2].classList.add("bg-info"); // Ganti indeks [1] dengan indeks yang sesuai
    modal_content[2].classList.remove("bg-danger");
    modal_content[2].classList.remove("bg-warning");
    modal_content[2].classList.remove("bg-success");
});

$('#tab2-progress-view2').on('shown.bs.tab', function (e) {
    modal_content[2].classList.remove("bg-info");
    modal_content[2].classList.add("bg-danger");
    modal_content[2].classList.remove("bg-warning");
    modal_content[2].classList.remove("bg-success");
});

$('#tab3-progress-view1').on('shown.bs.tab', function (e) {
    modal_content[2].classList.remove("bg-info");
    modal_content[2].classList.remove("bg-danger");
    modal_content[2].classList.add("bg-warning");
    modal_content[2].classList.remove("bg-success");
});

