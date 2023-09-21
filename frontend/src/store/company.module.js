/* eslint-disable no-unused-vars */
import CompanyService from "../services/company.service.js";
export const company = {
  namespaced: true,
  actions: {
    async getAll({ commit }, user) {
      console.log("getall");
      let result = await CompanyService.getAll();
      return result;
    },
  },
};