document.addEventListener('DOMContentLoaded', function () {
    const cepInput = document.getElementById('cep');
    if (!cepInput) return; // Trava de segurança caso a tela não tenha campo de CEP

    const ruaInput = document.getElementById('rua');
    const bairroInput = document.getElementById('bairro');
    const cidadeInput = document.getElementById('cidade');
    const estadoInput = document.getElementById('estado');
    const numeroInput = document.getElementById('numero');
    const errorElement = document.getElementById('cep-error');

    function toggleCamposLoading(carregando) {
        if (carregando) {
            ruaInput.value = 'Buscando...';
            bairroInput.value = 'Buscando...';
            cidadeInput.value = 'Buscando...';
            estadoInput.value = '...';
        } else {
            ruaInput.value = '';
            bairroInput.value = '';
            cidadeInput.value = '';
            estadoInput.value = '';
        }
    }

    cepInput.addEventListener('blur', function () {
        const cep = cepInput.value.replace(/\D/g, '');
        if (errorElement) errorElement.style.display = 'none';

        if (cep.length === 8) {
            toggleCamposLoading(true);

            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => response.json())
                .then(dados => {
                    if (dados.erro) {
                        toggleCamposLoading(false);
                        if (errorElement) errorElement.style.display = 'block';
                        ruaInput.removeAttribute('readonly');
                        bairroInput.removeAttribute('readonly');
                        cidadeInput.removeAttribute('readonly');
                        estadoInput.removeAttribute('readonly');
                    } else {
                        ruaInput.value = dados.logradouro;
                        bairroInput.value = dados.bairro;
                        cidadeInput.value = dados.localidade;
                        estadoInput.value = dados.uf;

                        dados.logradouro ? ruaInput.setAttribute('readonly', true) : ruaInput.removeAttribute('readonly');
                        dados.bairro ? bairroInput.setAttribute('readonly', true) : bairroInput.removeAttribute('readonly');

                        numeroInput.focus();
                    }
                })
                .catch(() => {
                    toggleCamposLoading(false);
                    ruaInput.removeAttribute('readonly');
                    bairroInput.removeAttribute('readonly');
                    cidadeInput.removeAttribute('readonly');
                    estadoInput.removeAttribute('readonly');
                });
        }
    });
});