function loadCsrfHeader(axios) {
  const csrf_token = document.querySelector("meta[name='csrf-token']").getAttribute("content");

  axios.defaults.headers.post['X-csrf-token'] = csrf_token;
  axios.defaults.headers.put['X-csrf-token'] = csrf_token;
  axios.defaults.headers.delete['X-csrf-token'] = csrf_token;
  axios.defaults.headers.patch['X-csrf-token'] = csrf_token;

  axios.defaults.headers.trace = {}
  axios.defaults.headers.trace['X-csrf-token'] = csrf_token
}

export function setupAxios(axios) {
  loadCsrfHeader(axios)
}