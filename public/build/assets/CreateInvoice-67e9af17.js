import{m as K,J as D,v as z,s as J,x as X,f as m,a as n,u as s,w as v,F as b,y as B,o as c,X as ee,b as e,t as _,e as te,g as w,i as d,p as S,z as A,q as p,d as h,c as O,l as Y}from"./app-3fd9687c.js";import{_ as se}from"./AuthenticatedLayout-cb2df174.js";import{_ as i}from"./InputError-62683f20.js";import{_ as E}from"./PrimaryButton-14819249.js";import{_ as G}from"./DangerButton-5cbdff95.js";import H from"./CreateEdit-2b18d1c3.js";import{Z as N}from"./main-a153b9b7.js";import{_ as u}from"./InputLabel-03840cc9.js";import{h as oe}from"./moment-a9aaa855.js";import"./SecondaryButton-27398031.js";import"./SuccessButton-4fabde40.js";const le={class:"page-wrapper"},ae={class:"page-content"},ne={class:"page-breadcrumb d-none d-sm-flex align-items-center mb-3"},re=e("div",{class:"breadcrumb-title pe-3"},"Manage Shipments",-1),de={class:"ps-3"},ie={"aria-label":"breadcrumb"},ce={class:"breadcrumb mb-0 p-0"},ue=e("li",{class:"breadcrumb-item"},[e("a",{href:"javascript:;"},[e("i",{class:"bx bx-home-alt"})])],-1),me={class:"breadcrumb-item active","aria-current":"page"},_e=e("div",{class:"ms-auto"},null,-1),pe={class:"card"},he={class:"card-body"},fe={class:"invoice overflow-auto"},ge={class:"row"},ve=e("h6",{class:"invoice-heading"},"INVOICE TO",-1),be=e("hr",null,null,-1),ye={key:0,class:"col-md-3"},xe={class:"col-md-3"},we=["value"],Ve={class:"col-md-2"},Ue={class:"col-md-2"},Ce={key:1,class:"col-md-2"},Se=e("option",{value:1},"Pending",-1),Ae=e("option",{value:2},"Approved",-1),Ie=e("option",{value:3},"Rejected",-1),ke=[Se,Ae,Ie],Te=e("div",{class:"my-3"},null,-1),$e={class:"row"},De={class:"col-md-4"},Ee=e("h6",{class:"invoice-heading"},"SHIPPER",-1),Ne=e("hr",null,null,-1),Pe={class:"row g-2"},Re={class:"col-md-12"},qe={for:"input13",class:"form-label"},Fe=e("i",{class:"bx bx-edit ms-1"},null,-1),Le=["value"],Me={class:"col-md-4"},Ke=e("h6",{class:"invoice-heading"},"CONSIGNEE",-1),Be=e("hr",null,null,-1),Oe={class:"row g-2"},Ye={class:"col-md-12"},Ge={for:"input13",class:"form-label"},He=e("i",{class:"bx bx-edit ms-1"},null,-1),je=["value"],Qe=e("div",{class:"my-3"},null,-1),We={class:"row g-2"},Ze=e("h6",{class:"invoice-heading"},"SHIPMENT DETAIL",-1),ze=e("hr",null,null,-1),Je={class:"col-md-3"},Xe={class:"col-md-3"},et={class:"col-md-3"},tt={class:"col-md-3"},st={class:"col-md-6"},ot={class:"col-md-1"},lt={class:"col-md-1"},at={class:"col-md-1"},nt=e("div",{class:"my-3"},null,-1),rt=e("h6",{class:"invoice-heading"},"PARTICULARS",-1),dt=e("hr",null,null,-1),it={style:{width:"5%"}},ct=e("i",{class:"bx bx-plus"},null,-1),ut=e("th",{class:"text-left",colspan:"3",style:{width:"45%"}},"PARTICULARS",-1),mt=e("th",{class:"text-left",style:{width:"15%"}},"UNIT PRICE",-1),_t=e("th",{class:"text-left",style:{width:"10%"}},"QUANTITY",-1),pt=e("th",{class:"text-left",style:{width:"15%"}},"TOTAL",-1),ht={class:"no",style:{width:"5%"}},ft=["onClick"],gt=e("i",{class:"bx bxs-trash"},null,-1),vt=[gt],bt={class:"text-left",colspan:"3",style:{width:"45%"}},yt=["onUpdate:modelValue"],xt={class:"text-left",style:{width:"15%"}},wt=["onUpdate:modelValue","onKeyup"],Vt={class:"text-left",style:{width:"10%"}},Ut=["onUpdate:modelValue","onKeyup"],Ct={class:"total",style:{width:"15%"}},St=e("td",{colspan:"4"},null,-1),At=e("td",{colspan:"2"},"SUBTOTAL",-1),It=e("td",{colspan:"4"},null,-1),kt=e("td",{colspan:"2"},"GRAND TOTAL",-1),Tt={class:"card-footer"},$t={class:"flex items-center gap-2 mt-2"},Ot={__name:"CreateInvoice",props:{invoice:Object,shippers:Array,consignees:Array,companies:Array,roles:Array,edit_mode:Boolean,page_type:String},setup(y){const j=K(!1),a=D().props.invoice,x=D().props.edit_mode,f=D().props.page_type;var P="",R="";const t=z({invoice_id:a==null?void 0:a.id,invoice_at:a==null?void 0:a.invoice_at,company_id:a==null?void 0:a.company_id,shipper_id:a==null?void 0:a.shipper_id,consignee_id:a==null?void 0:a.consignee_id,carrier:a==null?void 0:a.carrier,mawb_no:a==null?void 0:a.mawb_no,commodity:a==null?void 0:a.commodity,quantity:a==null?void 0:a.quantity,weight:a==null?void 0:a.weight,afc_rate:a==null?void 0:a.afc_rate,departure_at:a==null?void 0:a.departure_at,landing_at:a==null?void 0:a.landing_at,sender:a==null?void 0:a.sender,destination:a==null?void 0:a.destination,subtotal:0,total:0,items:a==null?void 0:a.items,status_id:a==null?void 0:a.status_id}),Q=()=>{t.items.push({particular:"",amount:"",qty:1,total:0})},W=()=>{console.log(f),f=="shipment"?x?t.post(route("shipment.update"),{preserveScroll:!0,onSuccess:()=>U(),onError:()=>V(),onFinish:()=>{}}):t.post(route("shipment.store"),{preserveScroll:!0,onSuccess:()=>U(),onError:()=>V(),onFinish:()=>{}}):f=="invoice"?t.post(route("invoice.update"),{preserveScroll:!0,onSuccess:()=>U(),onError:()=>V(),onFinish:()=>{}}):t.post(route("invoice.store"),{preserveScroll:!0,onSuccess:()=>U(),onError:()=>V(),onFinish:()=>{}})},V=()=>{},U=()=>{j.value=!1,t.reset()},Z=r=>{t.items.splice(r,1),I()},I=()=>{t.subtotal=0,t.items.forEach(r=>{t.subtotal+=parseFloat(r.total)}),t.total=t.subtotal},q=r=>{const l=t.items[r],o=l.qty*l.amount;l.total=o,I()},F=r=>{B.get(`/users/fetch/shipper/${r}`).then(({data:l})=>{P=l.selected_shipper})},L=r=>{B.get(`/users/fetch/consignee/${r}`).then(({data:l})=>{R=l.selected_consignee})},k=K(null),M=r=>{k.value.edit(r)},T=r=>new Intl.NumberFormat("en-US",{minimumFractionDigits:2,maximumFractionDigits:2}).format(r),$=r=>oe(r).format("YYYY-MM-DD HH:mm");return J(()=>{t.departure_at&&(t.departure_at=$(t.departure_at)),t.landing_at&&(t.landing_at=$(t.landing_at)),t.invoice_at&&(t.invoice_at=$(t.invoice_at))}),X(()=>{x||(t.items=[{particular:"",amount:0,qty:1,total:0}]),x&&I(),F(t.shipper_id),L(t.consignee_id)}),(r,l)=>(c(),m(b,null,[n(s(ee),{title:"Invoices"}),n(se,null,{default:v(()=>[e("div",le,[e("div",ae,[e("div",ne,[re,e("div",de,[e("nav",ie,[e("ol",ce,[ue,e("li",me,_(s(x)?"Create":"Edit"),1)])])]),_e]),e("div",pe,[e("form",{onSubmit:l[21]||(l[21]=te(o=>W(),["prevent"]))},[e("div",he,[e("div",fe,[e("div",ge,[ve,be,s(f)=="invoice"?(c(),m("div",ye,[n(u,{for:"",value:"Invoice Date",class:"mb-1"}),n(s(N),{modelValue:s(t).invoice_at,"onUpdate:modelValue":l[0]||(l[0]=o=>s(t).invoice_at=o),teleport:!0},null,8,["modelValue"]),n(i,{message:s(t).errors.invoice_at},null,8,["message"])])):w("",!0),e("div",xe,[n(u,{for:"",value:"Company Account",class:"mb-1"}),d(e("select",{class:"form-control","onUpdate:modelValue":l[1]||(l[1]=o=>s(t).company_id=o),onChange:l[2]||(l[2]=o=>r.fetchAddress("company"))},[(c(!0),m(b,null,A(y.companies,o=>(c(),m("option",{key:o.id,value:o.id},_(o.id)+" - "+_(o.name),9,we))),128))],544),[[S,s(t).company_id]]),n(i,{message:s(t).errors.company_id},null,8,["message"])]),e("div",Ve,[n(u,{for:"",value:"MAWB No",class:"mb-1"}),d(e("input",{type:"text",class:"form-control","onUpdate:modelValue":l[3]||(l[3]=o=>s(t).mawb_no=o)},null,512),[[p,s(t).mawb_no]]),n(i,{message:s(t).errors.mawb_no},null,8,["message"])]),e("div",Ue,[n(u,{for:"",value:"Carrier",class:"mb-1"}),d(e("input",{type:"text",class:"form-control","onUpdate:modelValue":l[4]||(l[4]=o=>s(t).carrier=o)},null,512),[[p,s(t).carrier]]),n(i,{message:s(t).errors.carrier},null,8,["message"])]),s(f)=="invoice"?(c(),m("div",Ce,[n(u,{for:"",value:"Invoice Status",class:"mb-1"}),d(e("select",{class:"form-control","onUpdate:modelValue":l[5]||(l[5]=o=>s(t).status_id=o)},ke,512),[[S,s(t).status_id]]),n(i,{message:s(t).errors.status_id},null,8,["message"])])):w("",!0)]),Te,e("div",$e,[e("div",De,[Ee,Ne,e("div",Pe,[e("div",Re,[e("label",qe,[h("Account Number "),n(H,{roles:y.roles,selected_role:3,ref_key:"create_edit_ref",ref:k},null,8,["roles"]),n(E,{onClick:l[6]||(l[6]=o=>M(s(P))),type:"button"},{default:v(()=>[h("Edit "),Fe]),_:1})]),d(e("select",{class:"form-control","onUpdate:modelValue":l[7]||(l[7]=o=>s(t).shipper_id=o),onChange:l[8]||(l[8]=o=>F(s(t).shipper_id))},[(c(!0),m(b,null,A(y.shippers,o=>(c(),m("option",{key:o.id,value:o.id},_(o.id)+" - "+_(o.name),9,Le))),128))],544),[[S,s(t).shipper_id]]),n(i,{message:s(t).errors.shipper_id},null,8,["message"])])])]),e("div",Me,[Ke,Be,e("div",Oe,[e("div",Ye,[e("label",Ge,[h("Account Number "),n(H,{roles:y.roles,selected_role:4,ref_key:"create_edit_ref",ref:k},null,8,["roles"]),n(E,{onClick:l[9]||(l[9]=o=>M(s(R))),type:"button"},{default:v(()=>[h("Edit "),He]),_:1})]),d(e("select",{class:"form-control","onUpdate:modelValue":l[10]||(l[10]=o=>s(t).consignee_id=o),onChange:l[11]||(l[11]=o=>L(s(t).consignee_id))},[(c(!0),m(b,null,A(y.consignees,o=>(c(),m("option",{key:o.id,value:o.id},_(o.id)+" - "+_(o.name),9,je))),128))],544),[[S,s(t).consignee_id]]),n(i,{message:s(t).errors.consignee_id},null,8,["message"])])])])]),Qe,e("div",We,[Ze,ze,e("div",Je,[n(u,{for:"",value:"Departure Date",class:"mb-1"}),n(s(N),{modelValue:s(t).departure_at,"onUpdate:modelValue":l[12]||(l[12]=o=>s(t).departure_at=o),teleport:!0,"is-24":!1},null,8,["modelValue"]),n(i,{message:s(t).errors.departure_at},null,8,["message"])]),e("div",Xe,[n(u,{for:"",value:"Landing Date",class:"mb-1"}),n(s(N),{modelValue:s(t).landing_at,"onUpdate:modelValue":l[13]||(l[13]=o=>s(t).landing_at=o),teleport:!0,"is-24":!1},null,8,["modelValue"]),n(i,{message:s(t).errors.landing_at},null,8,["message"])]),e("div",et,[n(u,{for:"",value:"Port of Departure",class:"mb-1"}),d(e("input",{type:"text",class:"form-control","onUpdate:modelValue":l[14]||(l[14]=o=>s(t).sender=o)},null,512),[[p,s(t).sender]]),n(i,{message:s(t).errors.sender},null,8,["message"])]),e("div",tt,[n(u,{for:"",value:"Port of Landing",class:"mb-1"}),d(e("input",{type:"text",class:"form-control","onUpdate:modelValue":l[15]||(l[15]=o=>s(t).destination=o)},null,512),[[p,s(t).destination]]),n(i,{message:s(t).errors.destination},null,8,["message"])]),e("div",st,[n(u,{for:"",value:"Commodity",class:"mb-1"}),d(e("input",{type:"text",class:"form-control","onUpdate:modelValue":l[16]||(l[16]=o=>s(t).commodity=o)},null,512),[[p,s(t).commodity]]),n(i,{message:s(t).errors.commodity},null,8,["message"])]),e("div",ot,[n(u,{for:"",value:"Quantity",class:"mb-1"}),d(e("input",{type:"text",class:"form-control","onUpdate:modelValue":l[17]||(l[17]=o=>s(t).quantity=o)},null,512),[[p,s(t).quantity]]),n(i,{message:s(t).errors.quantity},null,8,["message"])]),e("div",lt,[n(u,{for:"",value:"Weight",class:"mb-1"}),d(e("input",{type:"text",class:"form-control","onUpdate:modelValue":l[18]||(l[18]=o=>s(t).weight=o)},null,512),[[p,s(t).weight]]),n(i,{message:s(t).errors.weight},null,8,["message"])]),e("div",at,[n(u,{for:"",value:"AFC Rate/KG",class:"mb-1"}),d(e("input",{type:"text",class:"form-control","onUpdate:modelValue":l[19]||(l[19]=o=>s(t).afc_rate=o)},null,512),[[p,s(t).afc_rate]]),n(i,{message:s(t).errors.afc_rate},null,8,["message"])])]),s(f)=="invoice"?(c(),m(b,{key:0},[nt,rt,dt,e("table",null,[e("thead",null,[e("tr",null,[e("th",it,[e("button",{type:"button",onClick:l[20]||(l[20]=o=>Q()),class:"ms-1 text-sucess btn btn-success btn-sm"},[ct,h("Add Item")])]),ut,mt,_t,pt])]),e("tbody",null,[(c(!0),m(b,null,A(s(t).items,(o,C)=>(c(),m("tr",{key:o.id},[e("td",ht,[e("span",null,[h(" Item #"+_(C)+" ",1),e("button",{type:"button",onClick:g=>Z(C),class:"ms-1 text-danger"},vt,8,ft)])]),e("td",bt,[d(e("input",{type:"text",class:"form-control","onUpdate:modelValue":g=>o.particular=g},null,8,yt),[[p,o.particular]])]),e("td",xt,[d(e("input",{type:"number",class:"form-control","onUpdate:modelValue":g=>o.amount=g,onKeyup:g=>q(C)},null,40,wt),[[p,o.amount]])]),e("td",Vt,[d(e("input",{type:"number",class:"form-control","onUpdate:modelValue":g=>o.qty=g,onKeyup:g=>q(C)},null,40,Ut),[[p,o.qty]])]),e("td",Ct,"PKR "+_(T(o.total)),1)]))),128))]),e("tfoot",null,[e("tr",null,[St,At,e("td",null,"PKR "+_(T(s(t).subtotal)),1)]),e("tr",null,[It,kt,e("td",null,"PKR "+_(T(s(t).total)),1)])])])],64)):w("",!0)])]),e("div",Tt,[e("div",$t,[n(E,{disabled:s(t).processing},{default:v(()=>[h(_(s(x)?"Update":"Save"),1)]),_:1},8,["disabled"]),s(f)=="shipment"?(c(),O(s(Y),{key:0,href:r.route("shipment.index")},{default:v(()=>[n(G,{disabled:s(t).processing},{default:v(()=>[h(" Cancel ")]),_:1},8,["disabled"])]),_:1},8,["href"])):w("",!0),s(f)=="invoice"?(c(),O(s(Y),{key:1,href:r.route("invoice.index")},{default:v(()=>[n(G,{disabled:s(t).processing},{default:v(()=>[h(" Cancel ")]),_:1},8,["disabled"])]),_:1},8,["href"])):w("",!0)])])],32)])])])]),_:1})],64))}};export{Ot as default};
