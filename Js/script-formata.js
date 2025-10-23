function formatCPF(input) {
            let value = input.value.replace(/\D/g, '');

            if (value.length > 11) {
                value = value.slice(0, 11);
            }

            if (value.length > 9) {
                value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
            } else if (value.length > 6) {
                value = value.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
            } else if (value.length > 3) {
                value = value.replace(/(\d{3})(\d{1,3})/, '$1.$2');
            }

            input.value = value;
        }

function formatAltura(input) {
            let value = input.value.replace(/\D/g, '');

            if (value.length > 3) {
                value = value.slice(0, 3);
            }

            if (value.length > 3) {
                value = value.replace(/(\d{1})(\d{1,2})/, '$1.$2');
            } else if (value.length > 1) {
                value = value.replace(/(\d{1})(\d{1,2})/, '$1.$2');
            }

            input.value = value;
}