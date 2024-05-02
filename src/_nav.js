export default [
  {
    component: 'CNavItem',
    name: 'Dashboard',
    to: '/admin/dashboard',
    icon: 'cil-speedometer',
  },
  {
    component: 'CNavGroup',
    name: 'Blog et Boutique',
    icon: 'cil-cursor',
    items: [
      {
        component: 'CNavItem',
        name: 'Publier',
        to: '/admin/article-create',
      },
      {
        component: 'CNavItem',
        name: 'Liste des articles',
        to: '/admin/liste/liste-article',
      },
      {
        component: 'CNavItem',
        name: 'Ma boutique',
        to: '/admin/boutique',
      },
      {
        component: 'CNavItem',
        name: "Catégorie d'article",
        to: '/admin/liste/categorie-article',
      },
    ],
  },
  { 
    component: 'CNavGroup',
    name: 'Produits',
    icon: 'cil-list',
    items: [
      {
        component: 'CNavItem',
        name: 'Ajouter un produit',
        to: '/admin/produit-create',
      },
      {
        component: 'CNavItem',
        name: 'Liste des produits',
        to: '/admin/produits-list',
      },
      {
        component: 'CNavItem',
        name: 'Commandes',
        to: '/admin/commandes',
      },
      {
        component: 'CNavItem',
        name: "Catégorie",
        to: '/admin/liste-categorie',
      },
      {
        component: 'CNavItem',
        name: "Marque",
        to: '/admin/liste-marque',
      },
    ],
  },
  {
    component: 'CNavItem',
    name: 'Profile',
    to: '/admin/profile',
    icon: 'cil-user',
  },
]
