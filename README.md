# Lingerie

## Database

`users`

    id
    name
    email
    phone
    username
    role
    email_verified_at
    password
    created_at
    updated_at
    deleted_at

`props`

    id
    tab   // for panel
    type  // string, text, format_text, text_array, boolean, file, files, key

    title 
    value_string
    value_text
    position

`translations`

    lang
    key
    value

`pages`

    id
    slug
    lang
    title
    description
    meta_title
    meta_description
    meta_keywords
    route
    created_at
    updated_at
    deleted_at

`faqs`

    id
    lang
    title
    description
    position

### **Products**

`products`
    
    id
    is_published
    is_stock
    position
    created_at
    updated_at
    deleted_at
    
`product_translations`

    id
    product_id
    title
    slug
    lang
    price
    attributes
    meta_title
    meta_description
    meta_keywords
    
`product_attributes`
    
    id
    type
    value
    extra
    position
    
`product_attribute_product`

    product_id
    product_attribute_id
    
`product_categories`

    id
    slug
    position
    
`product_category_translations`

    id
    category_id
    slug
    lang
    title
    description
    meta_title
    meta_description
    meta_keywords
    
`product_category_product`

    product_id
    product_category_id



## Panel colors

    https://hihayk.github.io/scale/#4/5/85/90/0/0/0/0/c26c61/194/108/97/white
