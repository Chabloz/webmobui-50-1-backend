import { isRef, ref, unref, watch } from "vue";

export function useFetchJson(url, lazy = false, triggerFetchOnChange = true) {

  const data = ref(null);

  async function fetchJson(url){
    const response = await fetch(unref(url));
    const res = await response.json();
    data.value = res;
  }

  if (!lazy) fetchJson(url);

  if (isRef(url) && triggerFetchOnChange) watch(url, () => fetchJson(url));

  return {data, fetchJson: () => fetchJson(url)};
}