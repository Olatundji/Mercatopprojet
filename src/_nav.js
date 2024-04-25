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
        to: '/article-create',
      },
      {
        component: 'CNavItem',
        name: 'Liste des articles',
        to: '/article',
      },
      {
        component: 'CNavItem',
        name: 'Ma boutique',
        to: '/boutique',
      },
      {
        component: 'CNavItem',
        name: "Catégorie d'article",
        to: '/liste-article',
      },
    ],
  },
  {
    component: 'CNavGroup',
    name: 'Produits',
    icon: 'cil-cursor',
    items: [
      {
        component: 'CNavItem',
        name: 'Ajouter un produit',
        to: '/produit-create',
      },
      {
        component: 'CNavItem',
        name: 'Liste des produits',
        to: '/produits ',
      },
      {
        component: 'CNavItem',
        name: 'Commandes',
        to: '/commandes',
      },
      {
        component: 'CNavItem',
        name: "Catégorie",
        to: '/liste-article',
      },
      {
        component: 'CNavItem',
        name: "Marque",
        to: '/liste-article',
      },
    ],
  },
  {
    component: 'CNavItem',
    name: 'Profile',
    to: '/admin-profile',
    icon: 'cil-user',
  },
]
