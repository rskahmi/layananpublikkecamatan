function assignImg (component, data) {
    document.querySelector("#" + component).src = data
}

function assignInput (component, data) {
    document.querySelector("#" + component).value = data
}

function assignHtml (component, data) {
    document.querySelector("#" + component).innerHTML = data
}

function beritaPopUp (
    judul, gambar, deskripsi, tautan
) {
    assignHtml("judul-berita", judul)
    assignImg("gambarBerita", gambar)
    assignHtml("deskripsi", deskripsi)

    const container = document.querySelector("#anchor-container")

    container.innerHTML = ''

    if (container.children.length === 0) {
        tautan.forEach(item => {
        const anchor = document.createElement('a')
            anchor.classList.add('popup-link')

            anchor.target = '_blank'

            anchor.href = item.tautan

            anchor.textContent = getDomainOnly(item.tautan)

            container.appendChild(anchor)

            container.appendChild(document.createElement('br'));
        })
    }
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
