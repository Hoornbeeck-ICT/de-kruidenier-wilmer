function btn(val) {
    document.getElementById('input').value += val;
}

function operatorC(val) {
    document.getElementById('input').value = '';
}

function btn(val) {
    const input = document.getElementById('input');
    input.value += val;
    document.getElementById('formInputHidden').value = input.value;
}

function operatorC() {
    document.getElementById('input').value = '';
    document.getElementById('formInputHidden').value = '';
}


