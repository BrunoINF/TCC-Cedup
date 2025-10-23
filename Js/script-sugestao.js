function gerarSugestao() {
    const mensagem = document.getElementById('msg').innerText.toLowerCase();
    let sugestao = '';

if (
    mensagem.includes('definido') || 
    mensagem.includes('definição') || 
    mensagem.includes('trincado') || 
    mensagem.includes('abdômen') || 
    mensagem.includes('abdomen')
) {
    sugestao = 'Para definição, siga uma dieta rigorosa rica em proteínas magras, mantenha um déficit calórico e foque em treinos de força combinados com cardio moderado.';
} 
else if (
    mensagem.includes('emagrecer') || 
    mensagem.includes('perder peso') || 
    mensagem.includes('perder gordura') || 
    mensagem.includes('diminuir barriga') || 
    mensagem.includes('secar')
) {
    sugestao = 'Para emagrecer, combine treinos de alta intensidade (HIIT) com musculação e mantenha um déficit calórico controlado, priorizando proteínas e vegetais.';
} 
else if (
    mensagem.includes('ganhar massa') || 
    mensagem.includes('hipertrofia') || 
    mensagem.includes('crescer') || 
    mensagem.includes('aumentar músculos') || 
    mensagem.includes('ficar grande')
) {
    sugestao = 'Para ganhar massa muscular, aumente a ingestão calórica com foco em proteínas, carboidratos complexos e treinos de força progressivos.';
} 
else if (
    mensagem.includes('resistência') || 
    mensagem.includes('fôlego') || 
    mensagem.includes('condicionamento') || 
    mensagem.includes('corrida longa') || 
    mensagem.includes('endurance')
) {
    sugestao = 'Para resistência, priorize treinos aeróbicos de longa duração com intensidade moderada e aumente gradualmente o volume semanal.';
} 
else if (
    mensagem.includes('flexibilidade') || 
    mensagem.includes('alongamento') || 
    mensagem.includes('mobilidade')
) {
    sugestao = 'Para melhorar a flexibilidade, pratique alongamentos diários, yoga ou pilates, mantendo cada posição por pelo menos 30 segundos.';
} 
else if (
    mensagem.includes('força') || 
    mensagem.includes('potência') || 
    mensagem.includes('explosão')
) {
    sugestao = 'Para aumentar força e potência, faça treinos de musculação com cargas altas e baixas repetições, focando em exercícios compostos.';
} 
else if (
    mensagem.includes('saúde geral') || 
    mensagem.includes('bem estar') || 
    mensagem.includes('qualidade de vida')
) {
    sugestao = 'Para melhorar a saúde geral, mantenha um treino equilibrado com musculação, cardio moderado e alongamentos, além de sono e alimentação adequados.';
} 
else if (
    mensagem.includes('recuperação') || 
    mensagem.includes('lesão') || 
    mensagem.includes('reabilitação')
) {
    sugestao = 'Para recuperação, siga treinos leves e específicos recomendados por um fisioterapeuta, com foco em mobilidade e fortalecimento gradual.';
} 
else {
    sugestao = 'Mantenha uma rotina de treinos equilibrada e alimentação adequada de acordo com seu objetivo.';
}


    document.getElementById('resposta').value = sugestao;
}
