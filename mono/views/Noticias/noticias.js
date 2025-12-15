$(document).ready(() => {
  carga_noticias();
});

const carga_noticias = () => {
  let html = '';

  $.get(
    'https://newsapi.org/v2/everything?q=tesla&from=2025-11-08&sortBy=publishedAt&apiKey=21e19a04b593482ab81e194f16142f97',
    (lista_noticias) => {

      $.each(lista_noticias.articles, (index, noticia) => {
        html += `
          <tr>
            <td>
              <i class="fab fa-angular fa-lg text-danger me-3"></i>
              <strong>${noticia.title ?? 'Sin título'}</strong>
            </td>
            <td>${noticia.author ?? 'Desconocido'}</td>
            <td>
              <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                <li class="avatar avatar-xs pull-up">
                  <img src="${noticia.urlToImage ?? ''}" alt="Imagen" class="rounded-circle" />
                </li>
                <li class="avatar avatar-xs pull-up">
                  <p>${noticia.description ?? ''}</p>
                </li>
                <li class="avatar avatar-xs pull-up">
                  <a href="${noticia.url}" target="_blank">Seguir mirando</a>
                </li>
              </ul>
            </td>
          </tr>
        `;
      });

      $('#Contenido_Noticias').html(html);
    }
  );
};