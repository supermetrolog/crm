const API_URL = "https://api.pennylane.pro";
const CLIENT_URL = "https://clients.pennylane.pro";

$(document).ready(() => {
    replaceCompaniesInfo();
	replaceCompanyOfferInfo();
    replaceCompanyInfo();
});


function toQueryParams(object) {
	const params = Object.keys(object).reduce((acc, key) => {
		if (object[key] instanceof Array) {
			object[key].map(value => {
				acc.push(`${key}[]=${encodeURIComponent(value)}`)
			});
		} else {
			acc.push(`${key}=${encodeURIComponent(object[key])}`);
		}

		return acc;
	}, []);

	return params.join('&');
}

function plural(num, ...forms) {
	if (num % 10 === 1 && num % 100 !== 11) {
		return forms[0].replace('%d', num);
	}

	if (num % 10 >= 2 && num % 10 <= 4 && (num % 100 < 10 || num % 100 >= 20)) {
		return forms[1].replace('%d', num);
	}

	return forms[2].replace('%d', num);
}

async function replaceCompanyOfferInfo() {
	/** @type {HTMLElement[]} */
    const company_columns = Array.from(document.querySelectorAll(".offer-company-injector-container"));
	const company_ids = company_columns.map(el => el.dataset.company_id);

	if (!company_ids.length) return;

    const query = {
        fields: "full_name,id",
        id: company_ids,
        expand: "mainContact.phones,mainContact.emails,objects_count,contacts_count,requests_count,offers_count"
    }

	const companies = await searchCompany(query);
	if (!companies?.length) return;

    let contact_id = null;
	let company_id = null;

	company_columns.forEach(companyEl =>  {
		if (companyEl.dataset.contact_id) {
			contact_id = companyEl.dataset.contact_id;
			company_id = companyEl.dataset.company_id;
		}
	})

    const contact = await getContactById(contact_id);

    if (contact) {
        if (contact.full_name == null) contact.full_name = "Общий контакт";

		const companyIndex = companies.findIndex(item => Number(item.id) === Number(company_id));
		if (companyIndex !== -1) companies[companyIndex].mainContact = contact;
    }

    replace(companies, company_columns);

}
async function replaceCompanyInfo() {
    const company_columns = Array.from(document.querySelectorAll(".company-injector-container"));
    const company_ids = company_columns.map(el => el.dataset.company_id);

    if (!company_ids.length) return;

    const query = {
        fields: "full_name,id",
        id: company_ids,
        expand: "mainContact.phones,mainContact.emails,objects_count,contacts_count,requests_count,offers_count"
    }

    const companies = await searchCompany(query);

    if (companies?.length) replace(companies, company_columns);
}


async function replaceCompaniesInfo() {
    const company_columns = Array.from(document.querySelectorAll(".for-customer.obj-col-7"));
    const company_ids = company_columns.map(el => el.dataset.company_id);

	if (!company_ids.length) return;

    const query = {
        fields: "full_name,id",
        id: company_ids,
        expand: "mainContact.phones,mainContact.emails,contacts.phones,contacts.emails,objects_count,contacts_count,requests_count,offers_count"
    }

    const companies = await searchCompany(query);
	if (!companies?.length) return;

	const contact_list = company_columns.map(el => JSON.parse(el.dataset.contact));

	const company_list = [];

    contact_list.forEach(contact => {
		const company = companies.find(company => Number(company.id) === Number(contact.company_id));

		if (company) {
			if (company.contacts) {
				const currentContact = company.contacts.find(c => Number(c.id) === Number(contact.contact_id));
				if (currentContact) company.mainContact = currentContact;
			}

			company_list.push(company);
		}
    })

    replace(company_list, company_columns);
}

function createCountsElement(title) {
	const element = document.createElement("span");

	element.setAttribute(
		"style",
		"color: #436fcb;" +
		"text-decoration: underline;" +
		"margin-right: 5px;"
	);

	element.innerHTML = title;

	return element;
}

function createCompanyElement(company) {
	const company_link =  `${CLIENT_URL}/companies/${company.id}`;
	const company_name = company.full_name || "NONAME";

	const container = document.createElement("div");
	container.setAttribute("style", "margin-top: 5px;");

	const company_info = document.createElement("a");
	company_info.innerHTML = company_name;
	company_info.setAttribute("href", company_link);
	company_info.setAttribute("target", "_blank");
	company_info.setAttribute("style", "display: block;");

	container.append(company_info)

	if (company.contacts_count) {
		const title = plural(Number(company.contacts_count), '%d контакт', '%d контакта', '%d контактов');
		container.append(createCountsElement(title));
	}

	if (company.requests_count) {
		const title = plural(Number(company.requests_count), '%d запрос', '%d запроса', '%d запросов');
		container.append(createCountsElement(title));
	}

	if (company.objects_count) {
		const title = plural(Number(company.objects_count), '%d объект', '%d объекта', '%d объектов');
		container.append(createCountsElement(title));
	}

	if (company.offers_count) {
		const title = plural(Number(company.offers_count), '%d предложение', '%d предложения', '%d предложений');
		container.append(createCountsElement(title));
	}

	if (company.mainContact) {
		const contactInfoEl = document.createElement("p");
		contactInfoEl.innerHTML = company.mainContact.full_name;

		container.append(contactInfoEl);

		if (company.mainContact.phones?.length) {
			const phones = company.mainContact.phones.map(({phone}) => phone).join(", ");
			const phoneList = document.createElement("p");
			phoneList.innerHTML = phones;

			container.append(phoneList);
		}

		if (company.mainContact.emails?.length) {
			const emails = company.mainContact.emails.map(({email}) => email).join(", ");
			container.append(emails);
		}
	}

	return container;
}

function replace(companies, company_columns) {
	company_columns.forEach(companyEl => {
		const company = companies.find(company => Number(company.id) === Number(companyEl.dataset.company_id));
		if (!company) return;

		const companyElement = createCompanyElement(company);

		companyEl.append(companyElement);
	})
}

async function searchCompany(params) {
	const query = toQueryParams(params);

    const response = await fetch(`${API_URL}/companies?${query}`);

    return await response.json();
}

async function getContactById(id) {
	const query = toQueryParams({
		fields: 'id,full_name',
		expand: 'emails,phones'
	})

    const response = await fetch(`${API_URL}/contacts/${id}?${query}`);

    return await response.json();
}