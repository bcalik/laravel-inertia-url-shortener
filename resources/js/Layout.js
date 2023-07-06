import React, { useState } from 'react';
import { MantineProvider, ColorSchemeProvider } from '@mantine/core';
import LayoutContent from './LayoutContent';

export default function Layout(props) {
  const [colorScheme, setColorScheme] = useState('light');
  const toggleColorScheme = value => setColorScheme(value || (colorScheme === 'dark' ? 'light' : 'dark'));

  return (
    <ColorSchemeProvider colorScheme={colorScheme} toggleColorScheme={toggleColorScheme}>
      <MantineProvider
        withGlobalStyles
        withNormalizeCSS
        theme={{
          colorScheme,
          components: {
            Tooltip: {
              defaultProps: {
                openDelay: 200,
                withArrow: true,
                transitionProps: { transition: 'pop', duration: 50 },
              },
            },
          },
        }}
      >
        <LayoutContent {...props} />
      </MantineProvider>
    </ColorSchemeProvider>
  );
}
