Symfony 2 BannerBundle
============

Banner bundle for Symfony 2.3 or later


#Installation and configuration:

Pretty simple with Composer, add:

```json
    "cleverdev/banner-bundle": "dev-master"
```

#Configuration example
============

You can configure default query parameter names and templates

**Default**
```yaml
banner:
    banner_class: BannerBundle:Banner
    spots:
        header:
            name: Header
            template: 'BannerBundle:Banner:show.html.twig'
            params:
                max_count: 1
                max_width: 600
                max_height: 200
                order_by: id
                order_deriction: asc
        footer:
            name: Footer
            template: 'BannerBundle:Banner:show.html.twig'
            params:
                max_count: 1
                max_width: 600
                max_height: 200
                order_by: id
                order_deriction: asc
```

**Minimal**
```yaml
banner:
    spots:
        right:
            name: Right
            params: ~
```