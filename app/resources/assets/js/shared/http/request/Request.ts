import {RequestOptions} from "./RequestOptions";
import {DEFAULT_REQUEST_OPTIONS} from "./DefaultRequestOptions";
import {RequestResult} from "./RequestResult";
import { withQuery, parseXhrResult, errorResponse } from "./functions";

export function request(method: string | 'get' | 'post', url: string, queryParams: any = {}, body: any = null, options: RequestOptions = DEFAULT_REQUEST_OPTIONS) {

    const ignoreCache = options.ignoreCache || DEFAULT_REQUEST_OPTIONS.ignoreCache;
    const headers = options.headers || DEFAULT_REQUEST_OPTIONS.headers;
    const timeout = options.timeout || DEFAULT_REQUEST_OPTIONS.timeout;

    return new Promise<RequestResult>((resolve, reject) => {
        const  xhr = new XMLHttpRequest();

        xhr.open(method, withQuery(url, queryParams));

        if (headers) {
            Object.keys(headers).forEach(key => xhr.setRequestHeader(key, headers[key]));
        }

        if (ignoreCache) {
            xhr.setRequestHeader('Cache-Control', 'no-cache');
        }

        xhr.timeout = timeout;

        xhr.onload = evt => {
            resolve(parseXhrResult(xhr));
        }

        xhr.onerror = evt => {
            resolve(errorResponse(xhr, 'Failed to process the request'));
        }

        xhr.ontimeout = evt => {
            resolve(errorResponse(xhr, 'Request has taken longer than expected to get response.'));
        }

        if (method === 'post' && body) {
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.send(JSON.stringify(body));
        } else {
            xhr.send();
        }
    });
}