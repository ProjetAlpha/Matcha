function loadCsrfHeader(axios) {
  const csrf_token = document.querySelector("meta[name='csrf-token']").getAttribute("content");

  axios.defaults.headers.post['csrf-token'] = csrf_token;
  axios.defaults.headers.put['csrf-token'] = csrf_token;
  axios.defaults.headers.delete['csrf-token'] = csrf_token;
  axios.defaults.headers.patch['csrf-token'] = csrf_token;

  axios.defaults.headers.trace = {}
  axios.defaults.headers.trace['csrf-token'] = csrf_token
}

export function setupAxios(axios) {
  loadCsrfHeader(axios)
}