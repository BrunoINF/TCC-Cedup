/*Usuario*/

function bannirUsuario(cpf) {
    Swal.fire({
        title: "Banir Usuario?",
        text: "Deseja realmente banir o usuario?",
        icon: "warning",
        showDenyButton: true,
        confirmButtonText: "Banir",
        denyButtonText: "Cancelar",
        background: "#0C0E11",
        color: 'white',
        customClass: {
            confirmButton: 'DeletePop',
            denyButton: 'CancelPop',
        }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `Php/delete_user.php?cpf=${cpf}`;
        }
    });
}

function promoveUsuario(cpf) {
    Swal.fire({
        title: "Promover Usuario?",
        text: "Deseja realmente tornar o usuario a ADM?",
        icon: "question",
        showDenyButton: true,
        confirmButtonText: "Promover",
        denyButtonText: "Cancelar",
        background: "#0C0E11",
        color: 'white',
        customClass: {
            confirmButton: 'ConfirmPop',
            denyButton: 'CancelPop',
        }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `Php/promove_user.php?cpf=${cpf}`;
        }
    });
}

/* Exercicios */

function deletExerc(id) {
    Swal.fire({
        title: "Deletar exercicio?",
        text: "Deseja realmente deletar o exercicio?",
        icon: "warning",
        showDenyButton: true,
        confirmButtonText: "Deletar",
        denyButtonText: "Cancelar",
        background: "#0C0E11",
        color: 'white',
        customClass: {
            confirmButton: 'DeletePop',
            denyButton: 'CancelPop',
        }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `Php/delete_exerc.php?id_exercicio=${id}`;
        }
    });
}

/* Treino Publico */

function deletTrainingP(idTraining) {
    Swal.fire({
        title: "Deletar treino?",
        text: "Deseja realmente deletar o treino?",
        icon: "warning",
        showDenyButton: true,
        confirmButtonText: "Deletar",
        denyButtonText: "Cancelar",
        background: "#0C0E11",
        color: 'white',
        customClass: {
            confirmButton: 'DeletePop',
            denyButton: 'CancelPop',
        }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `Php/delete_trainingP.php?id_treino=${idTraining}`;
        }
    });
}