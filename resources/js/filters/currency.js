module.exports = (function (value) {
    return `${parseFloat(value).toLocaleString('en-US', { minimumFractionDigits: 2 })}`
})