// DevHer — scripts globais
document.addEventListener('DOMContentLoaded', () => {

  // revela elementos ao rolar a página
  const revealEls = document.querySelectorAll('.reveal');
  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); } });
  }, { threshold: 0.15 });
  revealEls.forEach(el => io.observe(el));

  // anima os contadores da seção de estatísticas
  const counters = document.querySelectorAll('.stat-num');
  const cIo = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const el = entry.target;
        const target = parseInt(el.getAttribute('data-count'), 10);
        let cur = 0;
        const step = Math.max(1, Math.round(target / 40));
        const t = setInterval(() => {
          cur += step;
          if (cur >= target) { cur = target; clearInterval(t); }
          el.textContent = cur + '%';
        }, 30);
        cIo.unobserve(el);
      }
    });
  }, { threshold: 0.4 });
  counters.forEach(c => cIo.observe(c));

  // menu mobile
  const toggle = document.querySelector('.nav-toggle');
  const links = document.querySelector('.nav-links');
  if (toggle && links) {
    toggle.addEventListener('click', () => {
      const open = links.classList.contains('nav-links-open');
      links.classList.toggle('nav-links-open', !open);
      links.style.display = open ? '' : 'flex';
      links.style.flexDirection = 'column';
      links.style.position = 'absolute';
      links.style.top = '64px';
      links.style.left = '0';
      links.style.right = '0';
      links.style.background = '#0A0A0D';
      links.style.padding = '20px 28px';
      links.style.borderBottom = '1px solid var(--line)';
      links.style.gap = '16px';
    });
  }

  // confirmação antes de excluir (usado nas tabelas do admin)
  document.querySelectorAll('[data-confirm]').forEach(form => {
    form.addEventListener('submit', (e) => {
      if (!confirm(form.getAttribute('data-confirm'))) e.preventDefault();
    });
  });
});

// Define a função globalmente no objeto window para ser chamada pelo evento onclick nos inputs de senha
window.togglePassword = function(inputId, buttonInfo) {
    // Captura o elemento do input de senha pelo seu ID
    const input = document.getElementById(inputId);
    // Localiza o elemento da tag <i> (ícone do Bootstrap) dentro do botão clicado
    const icon = buttonInfo.querySelector('i');

    // Verifica se o campo de texto está atualmente com o tipo 'password' (senha oculta)
    if (input.type === 'password') {
        // Altera o tipo do input para 'text' para revelar a senha
        input.type = 'text';
        // Troca a classe do ícone para o switch/toggle ligado
        icon.className = 'bi bi-toggle-on';
        // Aplica a cor rosa destacada (usando a variável CSS) quando visível
        icon.style.color = 'var(--pink-light)';
    } else {
        // Altera o tipo do input de volta para 'password' para ocultar a senha
        input.type = 'password';
        // Troca a classe do ícone para o switch/toggle desligado
        icon.className = 'bi bi-toggle-off';
        // Restaura a cor padrão do elemento
        icon.style.color = 'inherit';
    }
};