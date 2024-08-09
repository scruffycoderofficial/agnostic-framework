export interface RequestOptions {
    ignoreCache?: boolean;
    headers?: { [key:string]:string };
    timeout?: number;
}