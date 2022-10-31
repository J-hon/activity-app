import React from "react";
import ReactDOM from "react-dom/client";
import { Provider } from 'react-redux';
import App from "./Root/App";
import store from "./store";
import { BrowserRouter } from "react-router-dom";
import setup from "./services/http";

setup(store);

const root = ReactDOM.createRoot(document.getElementById("app"));
root.render(
    <Provider store={store}>
        <BrowserRouter>
            <App />
        </BrowserRouter>
    </Provider>
);
