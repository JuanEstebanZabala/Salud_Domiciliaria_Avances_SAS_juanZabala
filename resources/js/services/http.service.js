import axios from 'axios'
import { Notify } from './notification.service';
axios.defaults.baseURL = window.location.origin;

// api routes to exclude the notification error
//const excludeErrorNotification = ['auth/login']

/**
 * @author Juan Esteban Zabala
 * @class Api
 */
class Htpp {

    constructor() {

    }

    /**
     *
     * @param {Function} callback
     * @param {String} path
     * @param {Object} payload
     * @returns
     */
    async request(callback, path, payload) {
        try {
            const data = await callback(path, payload);
            if(data?.data?.message) Notify(data.data.message.type, data.data.message.text)
            return data;
        } catch (error) {
            if(error?.response?.data?.message) Notify(error.response.data.message.type, error.response.data.message.text)
            return error;
        }
    }

    /**
     * @param  {string} path
     * @param  {object} params
     */
    get(path, params = {}) {
        return this.request(axios.get, path, { params })
    }

    /**
     * @param  {string} path
     * @param  {object} payload
     */
    post(path, payload = {}) {
        return this.request(axios.post, path, payload)
    }

    /**
    * @param  {string} path
    * @param  {object} payload
    */
    put(path, payload = {}) {
        return this.request(axios.put, path, payload)
    }

    /**
     * @param  {string} path
     */
    delete(path, params = {}) {
        return this.request(axios.delete, path, { params })
    }

}

const http = new Htpp();
export { http };


