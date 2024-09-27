const sideMenu = document.querySelector("aside")
const menuBtn = document.querySelector("#menu-btn")
const closeBtn = document.querySelector("#close-btn")
const themeToggler = document.querySelector(".theme-toggler")

function verificarTamanhoTela(tamanho) {
    if (tamanho.matches) { // If media query matches
        sideMenu.style.display = 'none'
    } else {
        sideMenu.style.display = 'block'
    }
  }

// mostrar sidebar
menuBtn.addEventListener('click', () => {
    sideMenu.style.display = 'block'
})

// forçar display: block após none na resolução para tablet
var tamanhoTela = window.matchMedia("(max-width: 768px)")
verificarTamanhoTela(tamanhoTela) 
tamanhoTela.addListener(verificarTamanhoTela) 

// fechar sidebar
closeBtn.addEventListener('click', () => {
    sideMenu.style.display = 'none'
})

// mudar thema
themeToggler.addEventListener('click', () => {
    document.body.classList.toggle('dark-theme-variables')

    themeToggler.querySelector('span:nth-child(1)').classList.toggle('active')
    themeToggler.querySelector('span:nth-child(2)').classList.toggle('active')
})

//preencher pedidos na tabela
Orders.forEach(order => {
    const tr = document.createElement('tr')
    const trContent = `
    <td>${order.productName}</td>
    <td>${order.productNumber}</td>
    <td>${order.paymentStatus}</td>
    <td class="${order.shipping === 'Recusado' ? 'danger' : order.shipping === 'Pendente' ? 'warning' : 'primary'}">${order.shipping}</td>
    <td class="primary">Detalhes</td>
    `

    tr.innerHTML = trContent;
    document.querySelector('table tbody').appendChild(tr)
})
