import React from 'react';
import { ThemeIcon } from '@mantine/core';
import { Check } from 'tabler-icons-react';

export function IconCheck({ checked }) {
    if (!checked) {
        return (
            <ThemeIcon color="teal" variant="light" size={24} radius="xl"></ThemeIcon>
        );
    }

    return (
        <ThemeIcon color="teal" size={24} radius="xl">
            <Check size={16} />
        </ThemeIcon>
    );
}
