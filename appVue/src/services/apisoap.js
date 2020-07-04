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
}
