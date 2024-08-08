export default function queryParams(params: any = {}) {
    return Object.keys(params)
        .map(item => encodeURIComponent(item) + '=' + encodeURIComponent(params[item]))
        .join('&')
}