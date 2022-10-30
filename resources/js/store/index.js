import { configureStore } from "@reduxjs/toolkit";
import authSlice from "./auth.module";

const store = configureStore({
    reducer: {
        auth: authSlice.reducer
    },
    middleware: (getDefaultMiddleware) => getDefaultMiddleware(),
});

export default store;
