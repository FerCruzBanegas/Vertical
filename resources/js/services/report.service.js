import ApiService from './api.service'

const ReportService = {

  getIncomeAndExpenseForYear: async function(url) {
    try {
      const response = await ApiService.get(url)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  getReports: async function(url, params) {
    try {
      const response = await ApiService.getParams(url, params)
      return response
    } catch (error) {
      console.log(error)
    }
  },

  getReportPdf: async function(data) {
    try {
      const response = await ApiService.customRequest(data)
      return response
    } catch (error) {
      console.log(error)
    }
  }
}

export default ReportService
