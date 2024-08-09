import queryParams from "./QueryParams";

export default function withQuery(url: string, params: any = {}) {
    const queryString = queryParams(params);
    return queryString ? url + (url.indexOf('?') === -1 ? '?' : '&') + queryString: url;
}
