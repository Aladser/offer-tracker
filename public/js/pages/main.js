/** секуия рефссылок */
const refList = document.querySelector("#section-ref-list");
/** вебсокет */
const websocket = new MainClientWebsocket("ws://localhost:8888", refList);
