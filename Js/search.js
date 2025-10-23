document.addEventListener("DOMContentLoaded", () => {
    const searchBar = document.getElementById("searchBar");
    const resultados = document.getElementById("resultados");

    function buscarTreinos(query = "") {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "pesquisar_treino.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onload = function () {
            if (this.status === 200) {
                resultados.innerHTML = this.responseText;
            }
        };

        xhr.send("query=" + encodeURIComponent(query));
    }
    buscarTreinos();

    searchBar.addEventListener("input", () => {
        const valor = searchBar.value.trim();
        if (valor.length === 0) {
            buscarTreinos();
        } else {
            buscarTreinos(valor);
        }
    });
});

const searchInput = document.getElementById("searchExerc_<?= $modal_id; ?>");
const listaExerc = document.getElementById("listaExerc_<?= $modal_id; ?>");
searchInput.addEventListener("keyup", function () {
    const termo = this.value.toLowerCase();
    const itens = listaExerc.getElementsByClassName("exercicio-item");
    Array.from(itens).forEach(item => {
        const nome = item.querySelector(".nome-exercicio").textContent.toLowerCase();
        if (nome.includes(termo)) {
            item.style.display = "block";
        } else {
            item.style.display = "none";
        }
    });
});