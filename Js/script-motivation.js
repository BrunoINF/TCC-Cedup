  function gerarMotivacao() {
    const frases = [
      "O corpo alcança o que a mente acredita.",
      "Desistir não é uma opção, o progresso vem com consistência.",
      "Não importa o quão devagar você vá, desde que não pare.",
      "A dor é temporária, mas os resultados são permanentes.",
      "Cada repetição te aproxima do seu objetivo.",
      "Você não precisa ser perfeito, só não pode desistir.",
      "A disciplina vence a motivação.",
      "Quando pensar em parar, lembre-se do porquê começou.",
      "O treino de hoje é o resultado de amanhã.",
      "Ninguém se arrepende de ter treinado, só de ter faltado.",
      "Transforme esforço em hábito e hábito em resultado.",
      "Os campeões se fazem quando ninguém está olhando.",
      "Seu limite é apenas o começo de uma nova evolução.",
      "Um treino ruim ainda é melhor do que treino nenhum.",
      "Coragem é começar mesmo sem vontade.",
      "A cada gota de suor, você fica mais forte.",
      "Não existe atalho para um corpo forte, só dedicação.",
      "O que parece impossível hoje será seu aquecimento amanhã.",
      "Resultados não aparecem da noite pro dia, mas da consistência.",
      "Se fosse fácil, todo mundo faria. Você é diferente."
    ];

    const fraseAleatoria = frases[Math.floor(Math.random() * frases.length)];

    document.getElementById("motivacao").innerText = fraseAleatoria;
  }
  
  window.onload = gerarMotivacao;