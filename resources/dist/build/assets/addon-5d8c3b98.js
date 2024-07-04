function o(n,e,t,i,s,c,u,f){var r=typeof n=="function"?n.options:n;e&&(r.render=e,r.staticRenderFns=t,r._compiled=!0),i&&(r.functional=!0),c&&(r._scopeId="data-v-"+c);var a;if(u?(a=function(l){l=l||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext,!l&&typeof __VUE_SSR_CONTEXT__<"u"&&(l=__VUE_SSR_CONTEXT__),s&&s.call(this,l),l&&l._registeredComponents&&l._registeredComponents.add(u)},r._ssrRegister=a):s&&(a=f?function(){s.call(this,(r.functional?this.parent:this).$root.$options.shadowRoot)}:s),a)if(r.functional){r._injectStyles=a;var m=r.render;r.render=function(v,_){return a.call(_),m(v,_)}}else{var d=r.beforeCreate;r.beforeCreate=d?[].concat(d,a):[a]}return{exports:n,options:r}}const p={mixins:[Listing],props:["initialColumns"],data(){return{columns:this.initialColumns,sortColumn:"created_at",sortDirection:"desc",requestUrl:cp_url("overseer/executions/list")}},methods:{subject(n){const e={collection:"entry_id",taxonomy:"term_handle",global:"global_set",asset_container:"asset_id",navigation:null,tree:null},t=Object.keys(e).find(i=>n[i]);if(t)return[t,n[t],e[t]?n[e[t]]:null].filter(i=>i!==null).join(" / ")}}};var g=function(){var e=this,t=e._self._c;return t("div",[e.initializing?t("div",{staticClass:"w-full flex justify-center text-center"},[t("loading-graphic")],1):e._e(),e.initializing?e._e():t("data-list",{attrs:{"visible-columns":e.columns,columns:e.columns,rows:e.items,sort:!1,"sort-column":e.sortColumn,"sort-direction":e.sortDirection},scopedSlots:e._u([{key:"default",fn:function({filteredRows:i}){return t("div",{},[t("div",{staticClass:"card p-0 overflow-hidden"},[t("data-list-filters",{ref:"filters",attrs:{filters:e.filters,"active-filters":e.activeFilters,"active-filter-badges":e.activeFilterBadges,"active-count":e.activeFilterCount},on:{changed:e.filterChanged}}),t("data-list-table",{on:{sorted:e.sorted},scopedSlots:e._u([{key:"cell-created_at",fn:function({row:s}){return[t("a",{staticClass:"text-blue",attrs:{href:e.cp_url(`overseer/executions/${s.id}`)}},[e._v(" "+e._s(e.$moment(s.created_at).format("lll"))+" ")])]}},{key:"cell-subject",fn:function({row:s}){return[e._v(" "+e._s(e.subject(s))+" ")]}},{key:"cell-user",fn:function({row:s}){return[e._v(" "+e._s(s.user.name)+" "),s.impersonator?[e._v(" (impersonated by "+e._s(s.impersonator.name)+") ")]:e._e()]}}],null,!0)})],1),t("data-list-pagination",{staticClass:"mt-6",attrs:{"resource-meta":e.meta,"per-page":e.perPage},on:{"page-selected":e.selectPage,"per-page-changed":e.changePerPage}})],1)}}],null,!1,2879955520)}),e.showExecution?t("execution-view",{attrs:{id:e.activeExecution.id},on:{closed:e.closeExecution}}):e._e()],1)},h=[],C=o(p,g,h,!1,null,null,null,null);const b=C.exports,w={mixins:[Listing],props:["initialColumns"],data(){return{columns:this.initialColumns,sortColumn:"created_at",sortDirection:"desc",requestUrl:cp_url("overseer/events/list")}},methods:{subject(n){const e={collection:"entry_id",taxonomy:"term_handle",global:"global_set",asset_container:"asset_id",navigation:null,tree:null},t=Object.keys(e).find(i=>n[i]);if(t)return[t,n[t],e[t]?n[e[t]]:null].filter(i=>i!==null).join(" / ")}}};var y=function(){var e=this,t=e._self._c;return t("div",[e.initializing?t("div",{staticClass:"w-full flex justify-center text-center"},[t("loading-graphic")],1):e._e(),e.initializing?e._e():t("data-list",{attrs:{"visible-columns":e.columns,columns:e.columns,rows:e.items,sort:!1,"sort-column":e.sortColumn,"sort-direction":e.sortDirection},scopedSlots:e._u([{key:"default",fn:function({filteredRows:i}){return t("div",{},[t("div",{staticClass:"card p-0 overflow-hidden"},[t("data-list-filters",{ref:"filters",attrs:{filters:e.filters,"active-filters":e.activeFilters,"active-filter-badges":e.activeFilterBadges,"active-count":e.activeFilterCount},on:{changed:e.filterChanged}}),t("data-list-table",{on:{sorted:e.sorted},scopedSlots:e._u([{key:"cell-created_at",fn:function({row:s}){return[t("a",{staticClass:"text-blue",attrs:{href:e.cp_url(`overseer/executions/${s.execution_id}`)}},[e._v(" "+e._s(e.$moment(s.created_at).format("lll"))+" ")])]}},{key:"cell-subject",fn:function({row:s}){return[e._v(" "+e._s(e.subject(s))+" ")]}},{key:"cell-user",fn:function({row:s}){return[e._v(" "+e._s(s.user.name)+" "),s.impersonator?[e._v(" (impersonated by "+e._s(s.impersonator.name)+") ")]:e._e()]}}],null,!0)})],1),t("data-list-pagination",{staticClass:"mt-6",attrs:{"resource-meta":e.meta,"per-page":e.perPage},on:{"page-selected":e.selectPage,"per-page-changed":e.changePerPage}})],1)}}],null,!1,101873715)}),e.showEvent?t("event-view",{attrs:{id:e.activeEvent.id},on:{closed:e.closeEvent}}):e._e()],1)},$=[],j=o(w,y,$,!1,null,null,null,null);const k=j.exports,x={mixins:[Listing],props:["initialColumns"],data(){return{columns:this.initialColumns,sortColumn:"created_at",sortDirection:"desc",requestUrl:cp_url("overseer/audits/list")}},methods:{subject(n){return[n.model_type,n.model_handle,n.model_id].filter(e=>e!==null).join(" / ")}}};var F=function(){var e=this,t=e._self._c;return t("div",[e.initializing?t("div",{staticClass:"w-full flex justify-center text-center"},[t("loading-graphic")],1):e._e(),e.initializing?e._e():t("data-list",{attrs:{"visible-columns":e.columns,columns:e.columns,rows:e.items,sort:!1,"sort-column":e.sortColumn,"sort-direction":e.sortDirection},scopedSlots:e._u([{key:"default",fn:function({filteredRows:i}){return t("div",{},[t("div",{staticClass:"card p-0 overflow-hidden"},[t("data-list-filters",{ref:"filters",attrs:{filters:e.filters,"active-filters":e.activeFilters,"active-filter-badges":e.activeFilterBadges,"active-count":e.activeFilterCount},on:{changed:e.filterChanged}}),t("data-list-table",{on:{sorted:e.sorted},scopedSlots:e._u([{key:"cell-created_at",fn:function({row:s}){return[t("a",{staticClass:"text-blue",attrs:{href:e.cp_url(`overseer/executions/${s.execution_id}`)}},[e._v(" "+e._s(e.$moment(s.created_at).format("lll"))+" ")])]}},{key:"cell-subject",fn:function({row:s}){return[e._v(" "+e._s(e.subject(s))+" ")]}},{key:"cell-user",fn:function({row:s}){return[e._v(" "+e._s(s.user.name)+" "),s.impersonator?[e._v(" (impersonated by "+e._s(s.impersonator.name)+") ")]:e._e()]}}],null,!0)})],1),t("data-list-pagination",{staticClass:"mt-6",attrs:{"resource-meta":e.meta,"per-page":e.perPage},on:{"page-selected":e.selectPage,"per-page-changed":e.changePerPage}})],1)}}],null,!1,1306730386)})],1)},P=[],S=o(x,F,P,!1,null,null,null,null);const R=S.exports;Statamic.booting(()=>{Statamic.component("overseer-executions-listing",b),Statamic.component("overseer-events-listing",k),Statamic.component("overseer-audits-listing",R)});
