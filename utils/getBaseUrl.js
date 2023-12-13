export function getBaseUrl() {
    const requestUrl = useRequestURL();
    const protocol = requestUrl.protocol; // 'http:' или 'https:'
    const host = requestUrl.hostname; // 'localhost' или sharpss.ru
    // const port = requestUrl.port ? `:${requestUrl.port}` : ''; // раскомментируйте, если нужен порт

    return `${protocol}//${host}`;
}
