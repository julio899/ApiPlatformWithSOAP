const apikey = 'YrlU7hA6r-ybBVN-28'
const apiurl = 'http://localhost:8000/'
export default {
    registerAccount: async account => {
        return fetch(apiurl + 'v1/register', {
            method: 'POST',
            headers: {
                apikey,
                'Content-Type': 'application/xml',
            },
            body: `<client>
            			<name>${account.name}</name>
				        <lastname>${account.lastName}</lastname>
				        <email>${account.email}</email>
				        <document>${account.document}</document>
				        <tdoc>dni</tdoc>
				        <cellphone>${account.cellphone}</cellphone>
				 	</client>`,
        }).then(resp => {
            return resp.text().then(txt => {
                const parser = new DOMParser()
                return parser.parseFromString(txt.trim(), 'text/xml')
            })
        })
    },
    loginAccount: async account => {
        return fetch(apiurl + 'v1/login', {
            method: 'POST',
            headers: {
                apikey,
                'Content-Type': 'application/xml',
            },
            body: `<client>
            			<email>${account.email}</email>
				        <document>${account.document}</document>
				    </client>`,
        }).then(resp => {
            return resp.text().then(txt => {
                const parser = new DOMParser()
                return parser.parseFromString(txt.trim(), 'text/xml')
            })
        })
    },
    getBalance: async walletId => {
        return fetch(apiurl + `v1/${walletId}/balance`, { headers: { apikey, 'Content-Type': 'application/json' } })
            .then(r => {
                return r.json()
            })
            .then(resp => {
                return resp.balance
            })
    },
    getCode: async walletId => {
        return fetch(apiurl + `v1/${walletId}/getcode`, {
            method: 'POST',
            headers: { apikey, 'Content-Type': 'application/json' },
        })
            .then(r => {
                return r.json()
            })
            .then(resp => {
                return parseInt(resp.code)
            })
    },
    sendTranssaction: async (walletId, code, total) => {
        return fetch(apiurl + `v1/${walletId}/tanssaction`, {
            method: 'POST',
            headers: { apikey, 'Content-Type': 'application/json' },
            body: JSON.stringify({ code, total }),
        })
            .then(r => {
                return r.json()
            })
            .then(resp => {
                return resp
            })
    },
    sendDeposit: async (walletId, documento, phone, total) => {
        return fetch(apiurl + `v1/${walletId}/deposit`, {
            method: 'POST',
            headers: { apikey, 'Content-Type': 'application/json' },
            body: JSON.stringify({ documento, phone, total }),
        })
            .then(r => {
                return r.json()
            })
            .then(resp => {
                return resp
            })
    },
}
