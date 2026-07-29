// Aguarda o carregamento completo da estrutura da árvore DOM antes de executar os scripts
document.addEventListener('DOMContentLoaded', function () {
    // Seleciona o campo do input de CEP
    const cepInput = document.getElementById('cep');
    // Trava de segurança: interrompe a execução caso a página atual não possua o campo #cep
    if (!cepInput) return;

    // Captura as referências dos campos de endereço no formulário
    const ruaInput = document.getElementById('rua');
    const bairroInput = document.getElementById('bairro');
    const cidadeInput = document.getElementById('cidade');
    const estadoInput = document.getElementById('estado');
    const numeroInput = document.getElementById('numero');
    const errorElement = document.getElementById('cep-error');

    // Função interna para alterar o texto e o estado visual dos campos enquanto consulta a API
    function toggleCamposLoading(carregando) {
        if (carregando) {
            // Exibe mensagem temporária nos campos enquanto os dados são buscados
            ruaInput.value = 'Buscando...';
            bairroInput.value = 'Buscando...';
            cidadeInput.value = 'Buscando...';
            estadoInput.value = '...';
        } else {
            // Limpa os campos se o carregamento for interrompido ou falhar
            ruaInput.value = '';
            bairroInput.value = '';
            cidadeInput.value = '';
            estadoInput.value = '';
        }
    }

    // Adiciona o ouvinte de evento quando o usuário sai (perde o foco) do campo de CEP
    cepInput.addEventListener('blur', function () {
        // Remove todos os caracteres não numéricos digitados (máscaras, traços, etc.)
        const cep = cepInput.value.replace(/\D/g, '');
        // Oculta a mensagem de erro do CEP, caso esteja visível
        if (errorElement) errorElement.style.display = 'none';

        // Valida se o CEP possui exatamente 8 dígitos válidos
        if (cep.length === 8) {
            // Preenche os campos com a indicação de busca
            toggleCamposLoading(true);

            // Realiza a requisição assíncrona para a API da ViaCEP
            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => response.json()) // Converte a resposta recebida para JSON
                .then(dados => {
                    // Verifica se a API retornou o atributo de erro para CEPs inexistentes
                    if (dados.erro) {
                        // Limpa os textos de "Buscando..."
                        toggleCamposLoading(false);
                        // Exibe o elemento com a mensagem de erro
                        if (errorElement) errorElement.style.display = 'block';
                        // Libera a edição manual dos campos caso o CEP não seja localizado
                        ruaInput.removeAttribute('readonly');
                        bairroInput.removeAttribute('readonly');
                        cidadeInput.removeAttribute('readonly');
                        estadoInput.removeAttribute('readonly');
                    } else {
                        // Preenche os inputs com os dados retornados pela API
                        ruaInput.value = dados.logradouro;
                        bairroInput.value = dados.bairro;
                        cidadeInput.value = dados.localidade;
                        estadoInput.value = dados.uf;

                        // Se o logradouro existir no retorno, bloqueia a edição manual; caso contrário, libera para preenchimento
                        dados.logradouro ? ruaInput.setAttribute('readonly', true) : ruaInput.removeAttribute('readonly');
                        // Se o bairro existir no retorno, bloqueia a edição manual; caso contrário, libera
                        dados.bairro ? bairroInput.setAttribute('readonly', true) : bairroInput.removeAttribute('readonly');

                        // Move o foco do cursor automaticamente para o campo 'Número'
                        numeroInput.focus();
                    }
                })
                .catch(() => {
                    // Tratamento em caso de falha de conexão com a API da ViaCEP
                    toggleCamposLoading(false);
                    // Garante que o usuário consiga digitar o endereço manualmente se a API falhar
                    ruaInput.removeAttribute('readonly');
                    bairroInput.removeAttribute('readonly');
                    cidadeInput.removeAttribute('readonly');
                    estadoInput.removeAttribute('readonly');
                });
        }
    });
});