import axios from "axios";

export const apiget = async (url, params, headers) => {
  let response = null;
  await axios
    .get(url, { params, headers })
    .then((resp) => {
      response = resp;
    })
    .catch((err) => {
      if (err.code === "ERR_NETWORK") {
        err.status = 500;
        err.message = "Network Error; Error accessing server";
      }
      response = err;
    });
  return response;
};

export const apipost = async (url, data, headers) => {
  let response = null;
  await axios
    .post(url, data, { headers })
    .then((resp) => {
      response = resp;
    })
    .catch((err) => {
      if (err.code === "ERR_NETWORK") {
        err.status = 500;
        err.message = "Network Error; Error accessing server";
      }
      response = err;
    });
  return response;
};

export const apiput = async (url, data, headers) => {
  let response = null;
  await axios
    .put(url, data, { headers })
    .then((resp) => {
      response = resp;
    })
    .catch((err) => {
      if (err.code === "ERR_NETWORK") {
        err.status = 500;
        err.message = "Network Error; Error accessing server";
      }
      response = err;
    });
  return response;
};

export const apidelete = async (url, data, headers) => {
  let response = null;
  await axios
    .delete(url, data, { headers })
    .then((resp) => {
      response = resp;
    })
    .catch((err) => {
      if (err.code === "ERR_NETWORK") {
        err.status = 500;
        err.message = "Network Error; Error accessing server";
      }
      response = err;
    });
  return response;
};
