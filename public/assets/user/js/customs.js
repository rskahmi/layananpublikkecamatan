(function () {
    var btnLogout = document.getElementById("btn-logout");

    if (btnLogout) {
        btnLogout.addEventListener("click", function (event) {
            event.preventDefault();
            Swal.fire({
                title: "Konfirmasi",
                text: "Apakah ingin keluar?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya",
                cancelButtonText: "Tidak",
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = btnLogout.getAttribute("href");
                }
            });
        });
    }
})();

$(".btnDeleteData").click(function (e) {
    if ($(this)) {
        window.swal
            .fire({
                title: "Konfirmasi",
                text: "Anda ingin menghapus?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Hapus",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
            })
            .then((result) => {
                if (result.isConfirmed) {
                    var form = $(this).find("form");
                    // console.log(form.attr('action'));
                    form.submit();
                }
            });
    }
});

// Berkas
$(function () {
    let searchButton = document.getElementById("searchButton");
    if (searchButton) {
        searchButton.addEventListener("click", function () {
            var styles = {
                borderRadius: "0px",
                borderEndEndRadius: "5px",
                borderTopRightRadius: "5px",
            };

            Object.assign(searchButton.style, styles);

            var searchInput = document.getElementById("searchInput");
            searchInput.classList.toggle("active");
            if (searchInput.classList.contains("active")) {
                searchInput.focus();
            } else {
                var styles = {
                    borderRadius: "5px",
                };

                Object.assign(searchButton.style, styles);
            }
        });
    }
});

$(function () {
    $('[data-toggle="datepicker"]')
        .datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            zIndex: 2048,
        })
        .on("changeDate", function (e) {
            $(this).datepicker("hide");
        });
});

function select2wilayah(id, modal) {
    $("#" + id).select2({
        allowClear: true,
        dropdownParent: $("#" + modal + " .modal-content"),
        placeholder: "Masukkan Wilayah Pemohon",
        allowClear: true,
        language: {
            noResults: function () {
                return '<option value="newWilayah" id="newWilayah" data-bs-toggle="modal" data-bs-target="#newWilayahModal">Tambah Baru</option>';
            },
        },
        escapeMarkup: function (markup) {
            return markup;
        },
    });

    $("#" + id).on("select2:opening", function () {
        var $searchField = $(this)
            .siblings(".select2")
            .find(".select2-search__field");
        $searchField.focus();

        $searchField.on("keyup", function () {
            var query = $(this).val();

            if (!query) {
                $("#wilayah-select").val("newWilayah").trigger("change");
            }
        });
    });
}

function select2lembaga(id, modal, placeholder = "Masukkan Lembaga Pemohon") {
    $("#" + id).select2({
        dropdownParent: $("#" + modal + " .modal-content"),
        placeholder: placeholder,
        allowClear: true,
        tags: true,
    });

    $("#" + id).on("select2:select", function (e) {
        var selectedOption = e.params.data;
        if (selectedOption.id === "") {
            $(this).next().find(".select2-search__field").focus();
        }
    });
}

// function generateStatusBadge(status) {
//     var badgeClass;
//     switch (status.toLowerCase()) {
//         case 'aktif':
//             badgeClass = 'bg-success';
//             break;
//         case 'berakhir':
//             badgeClass = 'bg-danger';
//             break;
//         default:
//             badgeClass = 'bg-warning';
//     }

//     var badgeHTML = '<span class="badge ' + badgeClass + '">' + status + '</span>';
//     return badgeHTML;
// }

// function generateActionHTML(item) {
//     var editLink = '<a href="##edit" id="edit" onclick="modalEditIso(\'' +
//         item.nama + '\', \'' +
//         item.jenis + '\', \'' +
//         item.tgl_aktif + '\', \'' +
//         item.masa_berlaku + '\')"><x-svg.icon.edit/></a>';

//     var deleteLink = '<x-layout.delete action="' + '" />';

//     var actionHTML = '<div class="aksi">' + editLink + deleteLink + '</div>';

//     return actionHTML;
// }

// function formatDate(dateString) {
//     var months = [
//         'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
//         'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
//     ];

//     var date = new Date(dateString);
//     var day = date.getDate();
//     var monthIndex = date.getMonth();
//     var year = date.getFullYear();

//     return day + ' ' + months[monthIndex] + ' ' + year;
// }

$(function () {
    $("#btnSimpanWilayah").click(function (event) {
        event.preventDefault();

        var form = $(this).closest("form");

        var alamat = form.find("#alamat").val();
        var kelurahan = form.find("#kelurahan").val();
        var kecamatan = form.find("#kecamatan").val();
        var kabupaten = form.find("#kabupaten").val();
        var latitude = form.find("#latitude").val();
        var longitude = form.find("#longitude").val();

        const token = $('meta[name="csrf-token"]').attr("content");

        $.ajax({
            url: form.attr("action"),
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": token,
            },
            data: {
                alamat: alamat,
                kelurahan: kelurahan,
                kecamatan: kecamatan,
                kabupaten: kabupaten,
                latitude: latitude,
                longitude: longitude,
            },
            success: function (response) {
                if (response.status) {
                    const targetModal =
                        $("#newWilayahModal").attr("data-modal");
                    $(targetModal).modal("show");
                    $("#newWilayahModal").modal("hide");
                    // Set status to "success"
                    var alert = $("#alertWilayahModal");
                    alert.html(response.message);
                    alert.show();
                }
            },
            error: function (xhr, status, error) {
                var alert = $("#alertWilayah");
                alert.html(xhr.statusText);
                alert.show();
            },
        });
    });
});

function addDataToSelect2(data, identifier) {
    var select = $(identifier);

    data.forEach(function (item) {
        if (!select.find("option[value='" + item.value + "']").length) {
            select.append(
                '<option value="' + item.value + '">' + item.text + "</option>"
            );
        }
    });

    select.trigger("change");
}

$(function () {
    // $('[type="file"]').change(function () {
    //     var fileName = $(this).val().split("\\").pop();
    //     $("#fileLabel").text(fileName);
    // });
});


function modalEditSPD(
    action,
    tanggalberangkat,
    tanggalpulang,
    tujuan,
    lampiran = null
){
assignData("edttanggalberangkat", tanggalberangkat);
    assignData("edttanggalpulang", tanggalpulang);
    assignData("edttujuan", tujuan);
    assignData("edtlampiran", lampiran || "");
    setForm("#form-editModal", action);
}

function modalEditSPDL(
    action,
    tanggalberangkat,
    tanggalpulang,
    tujuan,
    lampiran = null
){
assignData("edttanggalberangkat", tanggalberangkat);
    assignData("edttanggalpulang", tanggalpulang);
    assignData("edttujuan", tujuan);
    assignData("edtlampiran", lampiran || "");
    setForm("#form-editModal", action);
}

function modalEditRotasi (
    action,
    memoteo = null
){
    assignData("edtmemoteo", memoteo || "");
    setForm("#form-editModal", action);
}

function modalEditPromosi (
    action,
    memoteo = null
){
    assignData("edtmemoteo", memoteo || "");
    setForm("#form-editModal", action);
}

function modalEditMutasi (
    action,
    memoteo = null
){
    assignData("edtmemoteo", memoteo || "");
    setForm("#form-editModal", action);
}

function modalEditRD(
    action,
    jenisrd,
    suratpermohonanbaru,
    suratpermohonanganti,
    simrd,
    suratpermohonankembalikan
) {
    assignData("edtsuratpermohonanbaru", suratpermohonanbaru);
    assignData("edtsuratpermohonanganti", suratpermohonanganti);
    assignData("edtsimrd", simrd);
    assignData("edtsuratpermohonankembalikan", suratpermohonankembalikan);

    // Set form action
    setForm("#form-editModal", action);

    // Set nilai dropdown dan trigger perubahan
    $("#edtJenis").val(jenisrd).trigger('change');

    // Atur tampilan elemen berdasarkan jenis NPP
    if (jenisrd.toLowerCase() === "baru") {
        // Tampilkan UMD dan sembunyikan Reim
        $("#edt-baru-only").removeClass("d-none");
        $("#edt-ganti-only").addClass("d-none");
        $("#edt-kembalikan-only").addClass("d-none");
    } else if (jenisrd.toLowerCase() === "ganti") {
        // Tampilkan Reim dan sembunyikan UMD
        $("#edt-ganti-only").removeClass("d-none");
        $("#edt-baru-only").addClass("d-none");
        $("#edt-kembalikan-only").addClass("d-none");
    } else if (jenisrd.toLowerCase() === "kembalikan") {
        // Tampilkan Reim dan sembunyikan UMD
        $("#edt-kembalikan-only").removeClass("d-none");
        $("#edt-ganti-only").addClass("d-none");
        $("#edt-baru-only").addClass("d-none");
    }

    else {
        // Sembunyikan semua elemen jika tidak sesuai
        $("#edt-baru-only").addClass("d-none");
        $("#edt-ganti-only").addClass("d-none");
        $("#edt-kembalikan-only").addClass("d-none");
    }
}



function modalEditSIJ(
    action,
    jenissij,
    emailberitaduka,
    suratrujukan,
    suratpengantar,
    lampiran
) {
    assignData("edtemailberitaduka", emailberitaduka);
    assignData("edtsuratrujukan", suratrujukan);
    assignData("edtsuratpengantar", suratpengantar);
    assignData("edtlampiran", lampiran);

    // Set form action
    setForm("#form-editModal", action);

    // Set nilai dropdown dan trigger perubahan
    $("#edtJenis").val(jenissij).trigger('change');

    // Atur tampilan elemen berdasarkan jenis NPP
    if (jenissij.toLowerCase() === "melayat") {
        // Tampilkan UMD dan sembunyikan Reim
        $("#edt-melayat-only").removeClass("d-none");
        $("#edt-sakit-only").addClass("d-none");
        $("#edt-dinas-only").addClass("d-none");
    } else if (jenissij.toLowerCase() === "sakit") {
        // Tampilkan Reim dan sembunyikan UMD
        $("#edt-sakit-only").removeClass("d-none");
        $("#edt-melayat-only").addClass("d-none");
        $("#edt-dinas-only").addClass("d-none");
    } else if (jenissij.toLowerCase() === "dinas") {
        // Tampilkan Reim dan sembunyikan UMD
        $("#edt-dinas-only").removeClass("d-none");
        $("#edt-melayat-only").addClass("d-none");
        $("#edt-sakit-only").addClass("d-none");
    }

    else {
        // Sembunyikan semua elemen jika tidak sesuai
        $("#edt-melayat-only").addClass("d-none");
        $("#edt-sakit-only").addClass("d-none");
        $("#edt-dinas-only").addClass("d-none");
    }
}



function modalEditNPP(
    action,
    jenisnpp,
    berkasrab = null,
    berkasnpp = null,
    nota = null,
    kwitansi = null,
    dokumenpersetujuan = null
) {
    // Assign data ke input (jika null, kosongkan input)
    assignData("edtberkasrab", berkasrab || "");
    assignData("edtberkasnpp", berkasnpp || "");
    assignData("edtnota", nota || "");
    assignData("edtkwitansi", kwitansi || "");
    assignData("edtdokumenpersetujuan", dokumenpersetujuan || "");

    // Set form action
    setForm("#form-editModal", action);

    // Set nilai dropdown dan trigger perubahan
    $("#edtJenis").val(jenisnpp).trigger('change');

    // Atur tampilan elemen berdasarkan jenis NPP
    if (jenisnpp.toLowerCase() === "umd") {
        // Tampilkan UMD dan sembunyikan Reim
        $("#edt-umd-only").removeClass("d-none");
        $("#edt-reim-only").addClass("d-none");
    } else if (jenisnpp.toLowerCase() === "reim") {
        // Tampilkan Reim dan sembunyikan UMD
        $("#edt-reim-only").removeClass("d-none");
        $("#edt-umd-only").addClass("d-none");
    } else {
        // Sembunyikan semua elemen jika tidak sesuai
        $("#edt-reim-only").addClass("d-none");
        $("#edt-umd-only").addClass("d-none");
    }
}

function modalEditBerkas(
    action,
    nomor_berkas,
    nama_berkas,
    nama_pemohon,
    tanggal,
    jenis_berkas,
    contact,
    lembaga_id = "",
    wilayah_id = "",
    jenis_program = ""
) {
    assignData("edtNomorBerkas", nomor_berkas);
    assignData("edtNamaBerkas", nama_berkas);
    assignData("edtNamaPemohon", nama_pemohon);
    assignData("edtContact", contact);
    assignData("edtTanggal", tanggal);

    setForm("#form-editModal", action);
    $("#edtJenis").val(jenis_berkas);

    if (jenis_berkas === "Surat" || jenis_berkas === "Undangan") {
        $("#edt-proposal-only").addClass("d-none");
    } else {
        $("#edt-proposal-only").removeClass("d-none");
        $("#edt-lembaga-select").val(lembaga_id).trigger("change");
        $("#edtJenisProgram").val(jenis_program)
        $("#edt-wilayah-select").val(wilayah_id).trigger("change");
    }
}

function modalEditTjsl(
    action,
    nama,
    wilayah,
    lembaga,
    anggaran,
    pic,
    contact,
    tanggal,
    jenis
) {
    assignData("edtNamaProgram", nama);
    assignData("edtPic", pic);
    assignData("edtContact", contact);
    assignData("edtTanggal", tanggal);
    assignData("edtAnggaran", formatInputCurrency(anggaran));
    setForm("#form-editModal", action);

    $("#edt_wilayah_select").val(wilayah).trigger("change");
    $("#edt_lembaga_select").val(lembaga).trigger("change");
    $("#edtJenis").val(jenis.toLowerCase());
    $("#editModal").modal("show");
}

function modalEditPumk(
    action,
    nama,
    contact,
    usaha,
    agunan,
    tanggal,
    tempo,
    wilayah,
    lembaga,
    anggaran
) {
    assignData("edtNama", nama);
    assignData("edtContact", contact);
    assignData("edtUsaha", usaha);
    assignData("edtAgunan", agunan);
    assignData("edtTanggal", tanggal);
    assignData("edtTempo", tempo);
    assignData("edtAnggaran", formatInputCurrency(anggaran));
    setForm("#form-editModal", action);
    $("#editModal").modal("show");

    $("#edt_wilayah_select").val(wilayah).trigger("change");
    $("#edt_lembaga_select").val(lembaga).trigger("change");
}

function assignData(component, data) {
    $("#" + component).val(data);
}

function setForm(component, action) {
    $(component).attr("action", action);
}

function setSummary(component) {
    $(component).text(parseInt($(component).text()) + 1);
}
function unsetSummary(component) {
    $(component).text(parseInt($(component).text()) - 1);
}

function setAnggaranSummary(component, newValue) {
    var anggaran = $(component).text();
    var anggaranNumbers = anggaran.replace(/[^0-9]/g, "");

    // Summ with new value
    var sum = parseInt(anggaranNumbers) + parseInt(newValue);
    var formattedCurrency = "Rp " + sum.toLocaleString();
    $(component).text(formattedCurrency);
}

function unsetAnggaranSummary(component, newValue) {
    var anggaran = $(component).text();
    var anggaranNumbers = anggaran.replace(/[^0-9]/g, "");

    // Summ with new value
    var sum = parseInt(anggaranNumbers) - parseInt(newValue);
    var formattedCurrency = "Rp " + sum.toLocaleString();
    $(component).text(formattedCurrency);
}

function parseToIdr(sum) {
    return "Rp " + sum.toLocaleString()
}

function modalEditIso(action, nama, jenis, tgl_aktif, masa_berlaku) {
    assignData("edtNama", nama);
    assignData("edtJenis", jenis);
    assignData("edtTglAktif", tgl_aktif);
    assignData("edtMasaBerlaku", masa_berlaku);
    setForm("#form-editISO", action);
    $("#editISO").modal("show");
}

function addNewInput(target, container, isEdt) {
    var edtMin = "tautan-min";
    if (isEdt) {
        edtMin = "edt-tautan-min";
    }

    $(target).click(() => {
        var newInput = $('<div class="input-group mb-3 ms-3"></div>');

        var inputElement = $(
            '<input type="url" class="form-control" placeholder="Masukkan Tautan media" name="tautan[]" aria-describedby="' +
                edtMin +
                '">'
        );

        var buttonElement = $(
            '<button class="input-group-text ' +
                edtMin +
                '" id="' +
                edtMin +
                '" >-</button>'
        );

        newInput.append(inputElement);
        newInput.append(buttonElement);

        $(container).append(newInput);
    });
}

function handlerGambar(component) {
    $("#" + component).change(function () {
        var fileName = $(this).val().split("\\").pop();
        $("." + component).text (fileName);
    });
}

function removeNewInput(target, inputRemove) {
    $(document).on("click", target, function () {
        $(this).closest(inputRemove).remove();
    });
}

var dataTables = {};

function dataTable(pageLength, id = "#dataTable") {
    var tableId = id.replace("#", "");
    dataTables[tableId] = $(id).DataTable({
        info: false,
        lengthMenu: false,
        sorting: false,
        pageLength: pageLength,
    });

    $("#searchInput").on("keyup", function () {
        var searchTerm = $(this).val();
        dataTables[tableId].search(searchTerm).draw();
        updatePagination(tableId)
    });

    updatePagination(tableId);

    $("#prev" + tableId).on("click", function (e) {
        e.preventDefault();
        if (!$(this).hasClass("disabled")) {
            dataTables[tableId].page("previous").draw("page");
            updatePagination(tableId);
        }
    });

    $("#next" + tableId).on("click", function (e) {
        e.preventDefault();
        if (!$(this).hasClass("disabled")) {
            dataTables[tableId].page("next").draw("page");
            updatePagination(tableId);
        }
    });

    $("#pagination" + tableId).on("click", ".page-link", function (e) {
        e.preventDefault();
        var page = $(this).data("page");
        dataTables[tableId].page(page).draw("page");
        updatePagination(tableId);
    });
}

function updatePagination(tableId) {
    var pageInfo = dataTables[tableId].page.info();
    var currentPage = pageInfo.page;
    var totalPages = pageInfo.pages;
    var pageLinks = "";

    if (totalPages <= 7) {
        for (var i = 0; i < totalPages; i++) {
            var activeClass = i === currentPage ? "active" : "";
            pageLinks +=
                '<a href="#" class="page-link ' +
                activeClass +
                '" data-page="' +
                i +
                '">' +
                (i + 1) +
                "</a>";
        }
    } else {
        var startPage = Math.max(currentPage - 2, 0);
        var endPage = Math.min(startPage + 4, totalPages - 1);

        if (startPage > 0) {
            pageLinks +=
                '<a href="#" class="page-link" data-page="0">1</a>';
            if (startPage > 1) {
                pageLinks += "<span>...</span>";
            }
        }

        for (var i = startPage; i <= endPage; i++) {
            var activeClass = i === currentPage ? "active" : "";
            pageLinks +=
                '<a href="#" class="page-link ' +
                activeClass +
                '" data-page="' +
                i +
                '">' +
                (i + 1) +
                "</a>";
        }

        if (endPage < totalPages - 1) {
            if (endPage < totalPages - 2) {
                pageLinks += "<span>...</span>";
            }
            pageLinks +=
                '<a href="#" class="page-link" data-page="' +
                (totalPages - 1) +
                '">' +
                totalPages +
                "</a>";
        }
    }

    $("#pagination" + tableId + " .page-links").html(pageLinks);

    $("#prevPage" + tableId).toggleClass("disabled", currentPage === 0);
    $("#nextPage" + tableId).toggleClass("disabled", currentPage === totalPages - 1);
}

function barChart(labels, datax) {
    const highestValue = Math.max(...datax);
    const adjustYValue = highestValue + highestValue / datax.length;

    const data = {
        labels: labels,
        datasets: [
            {
                label: "Pengajuan",
                backgroundColor: "#34B53A",
                borderColor: "transparent",
                borderWidth: 1,
                borderRadius: 40,
                barThickness: 6,
                data: datax,
            },
        ],
    };

    const config = {
        type: "bar",
        data: data,
        options: {
            scales: {
                x: {
                    grid: {
                        display: false,
                    },
                    ticks: {
                        borderWidth: 0,
                        font: {
                            size: 10,
                        },
                    },
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false,
                    },
                    ticks: {
                        stepSize: 2,
                        font: {
                            size: 10,
                        },
                    },
                    max: adjustYValue,
                },
            },
            plugins: {
                legend: {
                    display: false,
                },
                datalabels: {
                    display: false,
                },
            },
        },
    };

    // Create the chart
    var myChart = new Chart(document.getElementById("barChart"), config);
}

function formatDfy(dateString) {
    const months = monthNames(new Date(dateString).getMonth() + 1);
    const day = new Date(dateString).getDate();
    const year = new Date(dateString).getFullYear();
    return `${day} ${months} ${year}`;
}

function monthNames(index) {
    const indoMonthNames = [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember",
    ];

    return indoMonthNames[index - 1];
}

function createGradient(color1, color2) {
    const canvas = document.createElement("canvas");
    const ctx = canvas.getContext("2d");
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0.7, color1);
    gradient.addColorStop(1, color2);
    return gradient;
}

function anggaranChart(labels, datax, stepSize = 20) {
    const highestValue = Math.max(...datax);
    const adjustYValue = highestValue + highestValue / datax.length;

    const data2 = {
        labels: labels,
        datasets: [
            {
                label: "Anggaran",
                backgroundColor: createGradient("#36EBCA", "#1882FF"),
                barThickness: 24,
                data: datax,
            },
        ],
    };

    const config2 = {
        type: "bar",
        data: data2,
        options: {
            scales: {
                x: {
                    grid: {
                        display: false,
                    },
                    ticks: {
                        borderWidth: 0,
                        font: {
                            size: 10,
                        },
                    },
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false,
                    },
                    max: adjustYValue,
                    ticks: {
                        stepSize: stepSize,
                        font: {
                            size: 10,
                        },
                    },
                },
            },
            plugins: {
                legend: {
                    display: false,
                },
                datalabels: {
                    // Configure the datalabels plugin
                    color: "#4888E8", // Set the color for the labels
                    anchor: "end",
                    align: "top",
                    font: {
                        weigth: 700,
                        size: 15,
                    },
                    formatter: function (value, context) {
                        return value; // Display the value of each data point
                    },
                },
            },
        },
    };

    // Create the chart
    Chart.register(ChartDataLabels);
    var myChart2 = new Chart(document.getElementById("anggaranChart"), config2);
}

let editorInstances = {};

function createEditor(id) {
    if (editorInstances[id]) {
        editorInstances[id].destroy();
    }

    ClassicEditor.create(document.querySelector(id), {
        toolbar: {
            items: [
                "heading",
                "|",
                "bold",
                "italic",
                "|",
                "bulletedList",
                "numberedList",
                "|",
                "link",
                "insertTable",
                "|",
                "undo",
                "redo",
            ],
        },
    })
        .then((editor) => {
            editorInstances[id] = editor;
        })
        .catch((error) => {
        });
}

function createEditor(id, data) {
    if (editorInstances[id]) {
        editorInstances[id].destroy();
    }

    ClassicEditor.create(document.querySelector(id), {
        toolbar: {
            items: [
                "heading",
                "|",
                "bold",
                "italic",
                "|",
                "bulletedList",
                "numberedList",
                "|",
                "link",
                "insertTable",
                "|",
                "undo",
                "redo",
            ],
        },
    })
        .then((editor) => {
            editorInstances[id] = editor;
            editor.setData(data);
        })
        .catch((error) => {
        });
}

function updatePemberitaan(action, jenis, respon, tautanOrGambar)
{
    $("#edtJenis").val(jenis).trigger("change");
    $("#edtRespon").val(respon).trigger("change");

    if(jenis === 'media online') {
        $("#edtInputTautanContainer").show()
        $("#edtInputGambarContainer").hide()
        $("#edtTautan").val(tautanOrGambar)
    } else if (jenis === 'media elektronik' || jenis === 'media cetak') {
        $("#edtInputTautanContainer").hide()
        $("#edtInputGambarContainer").show()
        $("#containerGambarLama").show()
        $("#gambarLama").attr("src", tautanOrGambar)
    } else {
        $("#edtInputTautanContainer").hide()
        $("#edtInputGambarContainer").hide()
    }

    setForm("#form-editModal", action);
}

function modalEditMedia(action, judul, deskripsi, gambar) {
    assignData("edtJudul", judul);
    setForm("#form-editModal", action);

    $("#gambarLama").attr("src", gambar);

    if (editorInstances["#edtDeskripsiMedia"]) {
        editorInstances["#edtDeskripsiMedia"].setData(deskripsi);
    } else {
        console.error(
            "CKEditor instance with ID #edtDeskripsiMedia not found."
        );
    }
}

function modalEditProduk(action, deskripsi, kategori) {
    assignData("edtNama", deskripsi);
    setForm("#form-editProduk", action);

    $("#edtKategori").val(kategori);

    $("#editProduk").modal("show");

}

// format input anggaran
function formatInputCurrency(value) {
    value = value.replace(/[^0-9]/g, "");
    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    return value;
}

function pie(id, labels, data) {
    var canvas2 = document.getElementById(id);
    var ctx2 = canvas2.getContext("2d");

    var data = {
        labels: labels,
        datasets: [
            {
                data: data,
                backgroundColor: ["#145EA8", "#65AE38","#D12031"],
                offset: 5,
            },
        ],
    };

    // Define chart options
    var options2 = {
        responsive: true,
        plugins: {
            legend: {
                display: false,
            },
            datalabels: {
                font: {
                    size: 16,
                },
                color: "#fff",
                formatter: function (value, context) {
                    var sum = context.dataset.data.reduce((a, b) => a + b, 0);
                    var percentage = Math.round((value / sum) * 100) + "%";
                    return percentage;
                },
            },
        },
        rotation: -Math.PI / 2,
    };

    // Create the pie chart
    var pieChart = new Chart(ctx2, {
        type: "pie",
        data: data,
        options: options2,
        plugins: [ChartDataLabels], // Enable datalabels plugin
    });
}

function doughnutChart(id, colors, percentage) {
    var chart = document.getElementById(id).getContext("2d");

    var dataChart = [percentage, 100 - percentage];
    var colorsChart = colors;
    var cutoutChart = "85%";

    var myChart = new Chart(chart, {
        type: "doughnut",
        data: charts(dataChart, colorsChart, cutoutChart, percentage),
        options: options,
    });
}

function chartPemberitaan(id, title, labels, data) {
    var ctx = document.querySelector(id);

    var data = {
        labels: labels,
        datasets: [{
            label: title,
            data: data,
            backgroundColor: [
                '#65AE38',
                '#145EA8',
                '#D12031'
            ],
            hoverOffset: 4
        }]
    }

    var charts = new Chart(ctx, {
        type: 'doughnut',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: false,
                datalabels: {
                    color: "#FFF",
                    font: {
                        size: 13
                    },
                    formatter: (value, context) => {
                        if (value === 0) {
                            return '';
                        }
                        const dataset = context.dataset.data;
                        const total = dataset.reduce((sum, val) => sum + val, 0);
                        const percentage = (value / total * 100).toFixed(2) + '%';
                        return percentage;
                    }
                }
            },
            scales: {
                x: {
                    display: false
                },
                y: {
                    display: false
                }
            }
        },
        plugins: [ChartDataLabels]
    })
}

function gambarHandler(id) {
    $("#" + id).change(function () {
        var fileName = $(this).val().split("\\").pop();
        $("." + id).text(fileName);
    });
}

function showDetailStakeholderTjsl(action) {
    const token = $('meta[name="csrf-token"]').attr("content");

    $.ajax({
        url: action,
        method: "GET",
        headers: {
            "X-CSRF-TOKEN": token,
        },
        success: function (response) {
            dataTables["dataTable3"].clear().draw();
            response.forEach(function (item, index) {
                dataTables["dataTable3"].row
                    .add([
                        index + 1,
                        item.nama,
                        parseToIdr(item.anggaran),
                        formatDfy(item.tanggal),
                        item.pic
                    ])
                    .draw(false);
            });
            updatePagination("dataTable3")
        },
        error: function (xhr, status, error) {
            console.log(error);
        },
    });

    $("#detailTjsl").modal("show");
}

function showReview(review, nama, role)
{
    $("#modalReviewer").modal("show");
    $("#containerReviewer #role").html(role)
    $("#containerReviewer #nama").html(nama)
    $("#containerReviewer #review").html(review)
}



function currencyInInput(id) {
    $(id).on('input', function (event) {
        var value = event.target.value;

        event.target.value = formatInputCurrency(value)
    })

}

function showMore(link) {
    var fullTextDiv = link.previousElementSibling;
    var limitedTextDiv = fullTextDiv.previousElementSibling;
    if (fullTextDiv.style.display === "none") {
        fullTextDiv.style.display = "block";
        limitedTextDiv.style.display = "none"
        link.innerText = "Less";
    } else {
        limitedTextDiv.style.display = "block"
        fullTextDiv.style.display = "none";
        link.innerText = "More";
    }
}

function modalEditProgramUnggulan(
    action,
    nama_program,
    mitra_binaan,
    nama_kelompok,
    ketua_kelompok,
    contact,
    pic,
    deskripsi,
    wilayah,
    gambarLama
) {
    assignData("edtNamaProgram", nama_program);
    assignData("edtMitraBinaan", mitra_binaan);
    assignData("edtNamaKelompok", nama_kelompok);
    assignData("edtKetuaKelompok", ketua_kelompok);
    assignData("edtContact", contact);
    assignData("edtPic", pic);
    $("#gambarLama").attr("src", gambarLama)


    $("#edt_wilayah_select").val(wilayah).trigger("change");
    setForm("#form-editProgram", action);

    if (editorInstances["#edtDeskripsi"]) {
        editorInstances["#edtDeskripsi"].setData(deskripsi);
    } else {
        console.error(
            "CKEditor instance with ID #edtDeskripsi not found."
        );
    }

    $("#editProgram").modal("show");
}

