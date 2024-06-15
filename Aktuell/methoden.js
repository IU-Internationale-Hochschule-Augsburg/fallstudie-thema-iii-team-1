<script>

function loadData() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            textField.value = xhr.responseText;
        }
    };
    xhr.open('POST', "../../newtest.php", true); //Pfad korrekt angeben
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send("function=hell&tischnummer=" + element.id);
}
</script>