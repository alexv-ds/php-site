var toolbarOptions = [
  ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
  ['blockquote', 'code-block'],

  [{ 'header': 1 }, { 'header': 2 }],               // custom button values
  [{ 'list': 'ordered'}, { 'list': 'bullet' }],
  [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
  [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
  [{ 'direction': 'rtl' }],                         // text direction

  [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
  [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
  [ 'link', 'image'],

  [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
  [{ 'font': [] }],
  [{ 'align': [] }],

  ['clean'],                                       // remove formatting button
];

const quill = new Quill('#text-editor', {
  modules: {
    toolbar: toolbarOptions
  },
    placeholder: 'Идет медведь по лесу, видит...',
    theme: 'snow'
});

function submit_button(article_id) {
  const select_node = document.getElementById('scope-select');
  const data = {
    theme: document.getElementById('theme').value,
    scope: select_node[select_node.selectedIndex].id,
    content: quill.getContents()
  };

  const form = document.createElement('form');
  document.body.appendChild(form);
  form.method = 'post';
  if (article_id) {
    form.action = `/api/article_edit/edit/${article_id}`
  } else {
    form.action = `/api/article_edit/new`
  }

  console.log(form.action);

  const input = document.createElement('input');
  input.type = 'hidden';
  input.name = "data";
  input.value = JSON.stringify(data);
  form.appendChild(input);

  form.submit();
}