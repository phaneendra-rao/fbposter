import axios from "axios";

let webService = axios.create({
    baseURL: "http://fbposter.test/api/auth"
});

export default webService;
