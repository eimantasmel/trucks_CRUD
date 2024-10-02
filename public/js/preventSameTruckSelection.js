document.getElementById('main_truck_id').addEventListener('change', function() {
    let mainTruck = this.value;
    let subunitTruckSelect = document.getElementById('subunit_truck_id');

    // Enable all options first
    for (let i = 0; i < subunitTruckSelect.options.length; i++) {
        subunitTruckSelect.options[i].disabled = false;
    }

    // Disable the selected main truck option in the subunit select
    if (mainTruck) {
        subunitTruckSelect.querySelector(`option[value="${mainTruck}"]`).disabled = true;
    }
});

document.getElementById('subunit_truck_id').addEventListener('change', function() {
    let subunitTruck = this.value;
    let mainTruckSelect = document.getElementById('main_truck_id');

    // Enable all options first
    for (let i = 0; i < mainTruckSelect.options.length; i++) {
        mainTruckSelect.options[i].disabled = false;
    }

    // Disable the selected subunit truck option in the main truck select
    if (subunitTruck) {
        mainTruckSelect.querySelector(`option[value="${subunitTruck}"]`).disabled = true;
    }
});
