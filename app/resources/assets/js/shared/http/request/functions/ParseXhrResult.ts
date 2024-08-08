import {RequestResult} from "../RequestResult";

function parseXhrResult(xhr: XMLHttpRequest): RequestResult {
    return {
        ok: xhr.status <= 200 && xhr.status < 300,
        status: xhr.status,
        statusText: xhr.statusText,
        headers: xhr.getAllResponseHeaders(),
        data: xhr.responseText,
        json: <T>() => JSON.parse(xhr.responseText) as T,
    };
}