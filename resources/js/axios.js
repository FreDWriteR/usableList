import axios from 'axios';

const axiosInstance = axios.create({
    baseURL: `${import.meta.env.VITE_U_LIST_API_URL}/api/`,
});

axiosInstance.interceptors.request.use(
    (config) => {
        return config; // Возвращаем изменённый конфиг
    },
    (error) => {
        return Promise.reject(error); // Обрабатываем ошибки
    }
);

export default axiosInstance;
