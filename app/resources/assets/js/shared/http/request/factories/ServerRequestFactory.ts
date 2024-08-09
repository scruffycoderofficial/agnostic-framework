import {RequestResult} from "../RequestResult";
import {RequestOptions} from "../RequestOptions";
import {DEFAULT_REQUEST_OPTIONS} from "../DefaultRequestOptions";
import { withQuery, parseXhrResult, errorResponse } from "../functions";

/**
 * ServerRequestFactory
 */
export default class ServerRequestFactory implements RequestOptions
{
    ignoreCache?: boolean;
    headers?: { [key:string]:string };
    timeout?: number;
    xhr: XMLHttpRequest;
    queryParams: any;

    constructor(protected queryParams: any = {}, options: RequestOptions = DEFAULT_REQUEST_OPTIONS) {

        this.ignoreCache = options.ignoreCache || DEFAULT_REQUEST_OPTIONS.ignoreCache;
        this.headers = options.headers || DEFAULT_REQUEST_OPTIONS.headers;
        this.timeout = options.timeout || DEFAULT_REQUEST_OPTIONS.timeout;
        this.xhr = new XMLHttpRequest();

        if (this.headers) {
            Object.keys(this.headers).forEach(key => this.xhr.setRequestHeader(key, this.headers[key]));
        }

        if (this.ignoreCache) {
            xhr.setRequestHeader('Cache-Control', 'no-cache');
        }
    }

    createGetXmlRequest(url: string, body: any = {}): Promise<any> {
        return new Promise<RequestResult>((resolve, reject) => {
            this.xhr.open('get', withQuery(url, this.queryParams));

            this.xhr.onload = evt => {
                resolve(parseXhrResult(this.xhr));
            }

            this.xhr.onerror = evt => {
                resolve(errorResponse(this.xhr, 'Failed to process the GET request'));
            }

            this.xhr.ontimeout = evt => {
                resolve(errorResponse(this.xhr, 'Get request has taken longer than expected to get response.'));
            }

            this.xhr.send();
        });
    };


    createPostXmlRequest(url: string, body: any = {}): Promise<any> {
        return new Promise<RequestResult>((resolve, reject) => {
            this.xhr.open('post', withQuery(url, this.queryParams));

            this.xhr.onload = evt => {
                resolve(parseXhrResult(this.xhr));
            }

            this.xhr.onerror = evt => {
                resolve(errorResponse(this.xhr, 'Failed to process the POST request!'));
            }

            this.xhr.ontimeout = evt => {
                resolve(errorResponse(this.xhr, 'Post request has taken longer than expected to get response.'));
            }

            this.xhr.setRequestHeader('Content-Type', 'application/json');
            this.xhr.send(JSON.stringify(body));
        });
    };
}