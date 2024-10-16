export const fetchFilteredProperties = async (filterQuery) => {
    if (!filterQuery) return null;

    try {
        const response = await fetch(route('property.filter'), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.laravel.csrfToken,
            },
            body: JSON.stringify({
                filters: {
                    name: filterQuery,
                },
            }),
        });
        return await response.json();
    } catch (error) {
        console.error('Failed to fetch filtered properties:', error);
        throw error;
    }
};

export const fetchProperties = async (page = 1) => {
    try {
        const response = await fetch(`${route('properties.list')}?page=${page}`);
        return await response.json();
    } catch (error) {
        console.error('Failed to fetch properties:', error);
        throw error;
    }
};
