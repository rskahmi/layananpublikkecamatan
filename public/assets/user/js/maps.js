var map;
var kelurahan = document.getElementById("kelurahan");
var kecamatan = document.getElementById("kecamatan");
var kabupaten = document.getElementById("kabupaten");
var alamat = document.getElementById("alamat");

function getKabupatenByMap(datas) {
    const placeFeatures = datas.features.filter((feature) =>
        feature.place_type.includes("place")
    );
    const placeID = placeFeatures[0].id;
    const placeFeature = datas.features.find(
        (feature) => feature.id === placeID
    );
    const placeData = placeFeature.place_name;

    return placeData.split(",")[0];
}

function getKecamatanByMap(datas) {
    const localityFeatures = datas.features.filter((feature) =>
        feature.place_type.includes("locality")
    );
    const localityID = localityFeatures[0].id;
    const localityFeature = datas.features.find(
        (feature) => feature.id === localityID
    );
    const localityData = localityFeature.place_name;

    return localityData.split(",")[0];
}

function getKelurahanByMap(datas) {
    const neighborhoodFeatures = datas.features.filter((feature) =>
        feature.place_type.includes("neighborhood")
    );
    const neighborhoodId = neighborhoodFeatures[0].id;
    const neighborhoodFeature = datas.features.find(
        (feature) => feature.id === neighborhoodId
    );
    const neighborhoodData = neighborhoodFeature.place_name;

    return neighborhoodData.split(",")[0];
}

function getJalanByMap(datas) {
    try {
        const poiFeatures = datas.features.filter((feature) =>
            feature.place_type.includes("poi")
        );

        const poiId = poiFeatures[0].id;
        const poiFeature = datas.features.find(
            (feature) => feature.id === poiId
        );
        const data = {
            error: false,
            deksripsi: poiFeature.place_name,
        };

        return data;
    } catch (error) {
        const data = {
            error: true,
        };
        return data;
    }
}

function getAddressFromLatLng(latitude, longitude) {
    // Make a request to the Mapbox Geocoding API to get the address
    fetch(
        `https://api.mapbox.com/geocoding/v5/mapbox.places/${longitude},${latitude}.json?access_token=pk.eyJ1IjoibXJqcmZzMjIiLCJhIjoiY2xsOGNyZTkxMDNjZjNjbWE1M3J2cHFscyJ9.CsbC7todtywY-2ZMFYaQAg`
    )
        .then((response) => response.json())
        .then((datas) => {
            var getJalanErrorMessage = document.getElementById("jalan-error");
            if (getJalanByMap(datas).error === true) {
                alamat.value = "";
                getJalanErrorMessage.innerHTML =
                    "Pastikan memilih titik yang benar atau masukkan secara manual";
            } else {
                getJalanErrorMessage.innerHTML = "";
                alamat.value = getJalanByMap(datas).deksripsi;
            }

            kecamatan.value = getKecamatanByMap(datas);
            kelurahan.value = getKelurahanByMap(datas);
            kabupaten.value = getKabupatenByMap(datas);
        })
        .catch((error) => {
            console.error(error);
        });
}

function GetMap() {
    try {
        var map = new Microsoft.Maps.Map("#maps", {
            credentials:
                "AlUje-BfB7q-XcFYespJdjtmZY9wrhc1ismON5fsYXgvCUfb2hzSfiEN8UwdqqJ9",
        });

        var center = new Microsoft.Maps.Location(1.6692, 101.4478);

        map.setView({
            center: center,
            zoom: 15,
            mapTypeId: Microsoft.Maps.MapTypeId.aerial,
        });

        var currentPushpin;

        Microsoft.Maps.Events.addHandler(map, "click", function (e) {
            var location = e.location;
            var latitude = location.latitude;
            var longitude = location.longitude;

            if (currentPushpin) {
                map.entities.remove(currentPushpin);
            }

            var pin = new Microsoft.Maps.Pushpin(location, {
                icon: 'https://maps.gstatic.com/mapfiles/ms2/micons/blue-dot.png',
                anchor: new Microsoft.Maps.Point(12, 39)
            });

            map.entities.push(pin);
            currentPushpin = pin;

            document.getElementById("latitude").value = latitude;
            document.getElementById("longitude").value = longitude;
            const koordinat = latitude + ", " + longitude;
            document.querySelector("#koordinat").value = koordinat;
            getAddressFromLatLng(latitude, longitude);
        });
    } catch (error) {}
}
