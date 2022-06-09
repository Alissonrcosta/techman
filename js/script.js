function SenhaNum(num) {
    if (typeof gsenha == 'undefined') {
       document.senhaform.senha.value = '';
    }
    document.senhaform.senha.value = document.senhaform.senha.value + num;
    gsenha = 1;
 }
 
 function Limpar() {
    document.senhaform.senha.value = '';
    delete gsenha;
 }