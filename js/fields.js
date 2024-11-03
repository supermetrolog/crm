$(document).ready(() => {
    replaceCompaniesInfo()
    replaceCompanyOfferinfo();
    replaceCompanyInfo()
});
async function replaceCompanyOfferinfo() {
    const company_columns = document.querySelectorAll(".offer-company-injector-container");
    let company_ids = [].map.call(company_columns, el => el.dataset.company_id);

    const query = {
        fields: "full_name,id",
        id: company_ids.join(","),
        expand: "mainContact.phones,mainContact.emails,objects_count,contacts_count,requests_count,offers_count"
    }
    if (!company_ids.length) return;
    const companies = await searchCompany(query);

    let contact_id = null;
    let company_id = null;
    [].map.call(company_columns, el => {

        if (el.dataset.contact_id) {
            contact_id = el.dataset.contact_id;
            company_id = el.dataset.company_id;
        }
    });
    contact = await getContactById(contact_id);
    console.log(contact)
    if (contact) {
        if (contact.full_name == null) {
            contact.full_name = "Общий контакт"
        }
        companies.map(item => {
            console.log("COMPANY", item.id, )
            if (item.id == company_id) {
                item.mainContact = contact;
            }
            return item;
        });
    }

    replace(companies, company_columns);
    console.log(companies)
}
async function replaceCompanyInfo() {
    const company_columns = document.querySelectorAll(".company-injector-container");
    let company_ids = [].map.call(company_columns, el => el.dataset.company_id);

    const query = {
        fields: "full_name,id",
        id: company_ids.join(","),
        expand: "mainContact.phones,mainContact.emails,objects_count,contacts_count,requests_count,offers_count"
    }
    if (!company_ids.length) return;
    const companies = await searchCompany(query);
    replace(companies, company_columns);
    console.log(companies)
}


async function replaceCompaniesInfo() {
    const company_columns = document.querySelectorAll(".for-customer.obj-col-7");
    let company_ids = [].map.call(company_columns, el => el.dataset.company_id);
    const query = {
        fields: "full_name,id",
        id: company_ids.join(","),
        expand: "mainContact.phones,mainContact.emails,contacts.phones,contacts.emails,objects_count,contacts_count,requests_count,offers_count"
    }
    if (!company_ids.length) return;
    let companies = await searchCompany(query);
    let contact_list = [].map.call(company_columns, el => JSON.parse(el.dataset.contact));
    const company_list = [];
    contact_list.forEach((elem) => {
        let company = companies.find((company) => company.id == elem.company_id);
        if (company) {
            if (company.contacts) {
                let cn = company.contacts.find(c => c.id == elem.contact_id)
                if (cn) {
                    company.mainContact = cn;
                }
            }
            company_list.push(company);
        }
    })
    replace(company_list, company_columns);
    console.log(companies)
}

function replace(companies, company_columns) {
    [].forEach.call(company_columns, (el) => {
        const company = companies.find(company => company.id == el.dataset.company_id);

        if (!company) return;
        let company_name = {
            name: company.full_name || "NONAME",
            link: "https://clients.pennylane.pro/companies/" + company.id
        }

        let container = document.createElement("div");
        container.setAttribute("style", "margin-top: 5px;");

        const company_info = document.createElement("a");
        company_info.innerHTML = company_name.name
        company_info.setAttribute("href", company_name.link);
        company_info.setAttribute("target", "_blank");
        company_info.setAttribute("style", "display: block;");

        let requests_count = document.createElement("span")
        requests_count.setAttribute("style", "color: #436fcb; text-decoration: underline; margin-right: 5px;");
        requests_count.innerHTML = company.requests_count + " запросы"

        let contacts_count = document.createElement("span")
        contacts_count.setAttribute("style", "color: #436fcb; text-decoration: underline; margin-right: 5px;");
        contacts_count.innerHTML = company.contacts_count + " контакты"

        let objects_count = document.createElement("span")
        objects_count.setAttribute("style", "color: #436fcb; text-decoration: underline; margin-right: 5px;");
        objects_count.innerHTML = company.objects_count + " объекты"

        let offers_count = document.createElement("span")
        offers_count.setAttribute("style", "color: #436fcb; text-decoration: underline; margin-right: 5px;");
        offers_count.innerHTML = company.offers_count + " предложения"

        let contactInfoEl, phones, emails, phoneList;

        container.append(company_info)
        if (company.contacts_count) {
            container.append(contacts_count)
        }
        if (company.requests_count) {
            container.append(requests_count)
        }
        if (company.objects_count) {
            container.append(objects_count)
        }
        if (company.offers_count) {
            container.append(offers_count)
        }
        if (company.mainContact) {
            contactInfoEl = document.createElement("p")
            contactInfoEl.innerHTML = company.mainContact.full_name
            phones = company.mainContact.phones.map(phone => phone.phone).join(", ")
            phoneList = document.createElement("p")
            phoneList.innerHTML = phones

            emails = company.mainContact.emails.map(email => email.email).join(", ")
            container.append(contactInfoEl)
            container.append(phoneList)
            container.append(emails)
        }






        el.append(container)
    })
}
async function searchCompany(query) {
    query = new URLSearchParams(query).toString();
    let url = [
        "https://api.pennylane.pro/companies?",
        query
    ].join("")
    const response = await fetch(url);

    return await response.json();
}

async function getContactById(id) {
    let url = "https://api.pennylane.pro/contacts/" + id + "?fields=id,full_name&expand=emails,phones";
    const response = await fetch(url);

    return await response.json();
}
console.log('полей код загрузился');