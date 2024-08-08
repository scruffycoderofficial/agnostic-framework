import {RequestResult} from "../RequestResult";

function errorResponse(xhr: XMLHttpRequest, message: string | null = null): RequestResult
{
    return {
        ok: false,
        status: xhr.status,
        statusText: xhr.statusText,
        headers: xhr.getAllResponseHeaders(),
        data: message || xhr.responseText,
        json: <T>() => JSON.parse(xhr.responseText) as T,
    };
}